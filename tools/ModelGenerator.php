<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools;

use CuyZ\Valinor\MapperBuilder;
use Generator;
use JsonSerializable;
use LogicException;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use PromptJuggler\Client\Mapping\RawJson;
use PromptJuggler\Client\Tools\OpenApi\Discriminator;
use PromptJuggler\Client\Tools\OpenApi\Schema;
use PromptJuggler\Client\Tools\OpenApi\Spec;

/**
 * Generates the response models of an OpenAPI spec, and the Valinor config that maps JSON into them.
 */
final class ModelGenerator
{
    public const MODELS = 'PromptJuggler\Client\Models';
    public const UNKNOWN_ENUM_VALUE = 'UnknownEnumValue';

    private const MAPPING = 'PromptJuggler\Client\Mapping';
    private const IDENTIFIER = '/^[A-Za-z_\x80-\xff][A-Za-z0-9_\x80-\xff]*$/';

    // Lowercase. PHP rejects them as class names whatever their case.
    private const RESERVED_WORDS = [
        '__halt_compiler', 'abstract', 'and', 'array', 'as', 'bool', 'break', 'callable', 'case', 'catch', 'class',
        'clone', 'const', 'continue', 'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty',
        'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'false',
        'final', 'finally', 'float', 'fn', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements',
        'include', 'include_once', 'instanceof', 'insteadof', 'int', 'interface', 'isset', 'iterable', 'list',
        'match', 'mixed', 'namespace', 'never', 'new', 'null', 'object', 'or', 'parent', 'print', 'private',
        'protected', 'public', 'readonly', 'require', 'require_once', 'return', 'self', 'static', 'string', 'switch',
        'throw', 'trait', 'true', 'try', 'unset', 'use', 'var', 'void', 'while', 'xor', 'yield',
    ];

    /** @var array<string, Schema> Object schemas reachable from a response, by name. */
    private readonly array $classes;

    /** @var array<string, Union> Discriminated unions reachable from a response, by name. */
    private readonly array $unions;

    /** @var array<string, array<string, string>> Discriminator values, by variant and discriminator property. */
    private readonly array $tags;

    /** @var array<string, StringEnum> Named enums reachable from a response, and inline enums, by name. */
    private readonly array $enums;

    private readonly TypeMapper $types;

    public function __construct(
        private readonly Spec $spec,
    ) {
        $reachable = [];
        foreach ($spec->responseBodies() as $where => $schema) {
            $reachable = $this->collectRefs($schema, $where, $reachable);
        }
        ksort($reachable);
        array_walk($reachable, self::checkComponent(...));

        $this->classes = array_filter($reachable, self::isClass(...));
        $discriminators = array_map(static fn (Schema $schema): ?Discriminator => $schema->discriminator, $reachable);
        $this->unions = self::mapWithKeys(array_filter($discriminators), $this->union(...));
        $this->tags = $this->tags();

        $inline = self::nameInlineEnums(iterator_to_array($this->inlineEnumUses(), false));
        self::checkClassNames([
            ...array_map(static fn (string $name): array => [$name, $name], array_keys($reachable)),
            ...array_map(static fn (array $enum): array => [$enum['keys'][0], $enum['enum']->name], $inline),
            ...array_map(
                static fn (Union $union): array => [$union->name, $union->unknown()],
                array_values($this->unions),
            ),
            ['generator', self::UNKNOWN_ENUM_VALUE],
        ]);
        $enums = [
            ...self::mapWithKeys(array_filter($reachable, self::isEnum(...)), self::namedEnum(...)),
            ...array_column($inline, 'enum', 'name'),
        ];
        ksort($enums);
        $this->enums = $enums;
        $inlineNames = array_map(
            static fn (array $enum): array => array_fill_keys($enum['keys'], $enum['name']),
            $inline,
        );
        $this->types = new TypeMapper($spec, $enums, array_merge(...$inlineNames));
        foreach ($spec->responseBodies() as $where => $schema) {
            $this->types->checkResponseBody($schema, $where);
        }
    }

    /**
     * @return array<string, string> PHP sources, by path relative to the package's `src/`, sorted.
     */
    public function generate(): array
    {
        $unions = array_values($this->unions);
        $models = [
            ...self::mapWithKeys($this->classes, $this->classFile(...)),
            ...array_map($this->enumFile(...), $this->enums),
            ...array_map(self::interfaceFile(...), $this->unions),
            ...array_combine(
                array_map(static fn (Union $union): string => $union->unknown(), $unions),
                array_map(self::unknownFile(...), $unions),
            ),
            self::UNKNOWN_ENUM_VALUE => self::unknownEnumValueFile(),
        ];
        $printer = new PsrPrinter();
        $sources = [
            'Mapping/ModelMapping.php' => $printer->printFile($this->mappingFile()),
            ...array_combine(
                array_map(static fn (string $name): string => "Models/{$name}.php", array_keys($models)),
                array_map($printer->printFile(...), array_values($models)),
            ),
        ];
        ksort($sources);

        return $sources;
    }

    public static function fqn(string $model): string
    {
        return self::MODELS . "\\{$model}";
    }

    /**
     * @param array<string, Schema> $found
     * @return array<string, Schema> `$found` plus the component schemas reachable from `$schema`, by name.
     */
    private function collectRefs(Schema $schema, string $path, array $found): array
    {
        if ($schema->ref !== null) {
            $name = $this->spec->schemaName($schema->ref, $path);
            if (isset($found[$name])) {
                return $found;
            }
            $component = $this->spec->schema($name);

            return $this->collectRefs($component, $name, [...$found, $name => $component]);
        }
        foreach ($schema->children() as $child => $childSchema) {
            $found = $this->collectRefs($childSchema, "{$path}.{$child}", $found);
        }

        return $found;
    }

    private static function checkComponent(Schema $schema, string $name): void
    {
        if ($schema->oneOf !== null && !$schema->discriminator) {
            throw new GeneratorException("{$name}: a oneOf schema needs a discriminator");
        }
        if ($schema->enum !== null && $schema->types() !== ['string']) {
            throw new GeneratorException("{$name}: an enum needs `type: string`");
        }
        if (self::isClass($schema) && !$schema->properties) {
            throw new GeneratorException("{$name}: needs properties, an enum or a discriminated oneOf");
        }
    }

    private static function isClass(Schema $schema): bool
    {
        return !$schema->discriminator && $schema->enum === null;
    }

    private static function isEnum(Schema $schema): bool
    {
        return !$schema->discriminator && $schema->enum !== null;
    }

    private static function namedEnum(string $name, Schema $schema): StringEnum
    {
        return new StringEnum($name, $schema->enum ?? [], true, $schema->description);
    }

    private function union(string $name, Discriminator $discriminator): Union
    {
        $schema = $this->spec->schema($name);
        $oneOf = $schema->oneOf ?? [];
        $members = array_map(
            fn (int $i, Schema $member): string => $this->spec->schemaName(
                $member->ref ?? throw new GeneratorException("{$name}.oneOf[{$i}]: a union's variants must be \$refs"),
                "{$name}.oneOf[{$i}]",
            ),
            array_keys($oneOf),
            $oneOf,
        );
        $variants = array_map(
            fn (string $ref): string => $this->spec->schemaName($ref, "{$name}.discriminator.mapping"),
            $discriminator->mapping,
        );
        if (array_diff($members, $variants) || array_diff($variants, $members)) {
            throw new GeneratorException("{$name}: the discriminator mapping must list exactly the oneOf variants");
        }

        return new Union($name, $schema->description, $discriminator->propertyName, $variants);
    }

    /**
     * @return array<string, array<string, string>>
     */
    private function tags(): array
    {
        $tags = [];
        foreach ($this->unions as $union) {
            foreach ($union->variants as $tag => $variant) {
                $schema = $this->classes[$variant]
                    ?? throw new GeneratorException("{$union->name}: variant `{$variant}` must be an object schema");
                $path = "{$variant}.{$union->property}";
                $discriminator = $schema->properties[$union->property]
                    ?? throw new GeneratorException("{$path}: missing, but {$union->name} discriminates on it");
                $earlier = $tags[$variant][$union->property] ?? $tag;
                if (($discriminator->enum !== null && $discriminator->enum !== [$tag]) || $earlier !== $tag) {
                    throw new GeneratorException("{$path}: must be `{$tag}` only, for {$union->name}");
                }
                $tags[$variant][$union->property] = $tag;
            }
        }

        return $tags;
    }

    /**
     * @return Generator<array{owner: string, property: string, values: list<string>, open: bool}>
     */
    private function inlineEnumUses(): Generator
    {
        foreach ($this->classes as $owner => $schema) {
            foreach ($schema->properties as $property => $propertySchema) {
                $values = $propertySchema->enum;
                if ($values !== null && !isset($this->tags[$owner][$property])) {
                    yield ['owner' => $owner, 'property' => $property, 'values' => $values, 'open' => true];
                }
            }
        }
        foreach ($this->spec->requestBodies() as $where => $body) {
            if (!$body->ref) {
                if ($body->properties) {
                    throw new GeneratorException("{$where}: an object with properties needs a component schema");
                }

                continue;
            }
            $owner = $this->spec->schemaName($body->ref, $where);
            foreach ($this->spec->schema($owner)->properties as $property => $propertySchema) {
                $values = $propertySchema->enum ?? [];
                if (\count($values) > 1) {
                    yield ['owner' => $owner, 'property' => $property, 'values' => $values, 'open' => false];
                }
            }
        }
    }

    /**
     * An inline enum is named `{Schema}{Property}`, or `{Property}` when several schemas share it.
     *
     * @param list<array{owner: string, property: string, values: list<string>, open: bool}> $uses
     * @return list<array{name: string, enum: StringEnum, keys: non-empty-list<string>}> With the
     *     `Schema.property`s that use each.
     */
    private static function nameInlineEnums(array $uses): array
    {
        $groups = [];
        foreach ($uses as $use) {
            $groups[serialize([$use['property'], $use['values']])][] = $use;
        }

        return array_map(static function (array $group): array {
            $owners = array_values(array_unique(array_column($group, 'owner')));
            $property = ucfirst($group[0]['property']);
            $name = \count($owners) > 1 ? $property : $owners[0] . $property;
            $open = \in_array(true, array_column($group, 'open'), true);
            $keys = array_map(static fn (array $use): string => "{$use['owner']}.{$use['property']}", $group);

            return [
                'name' => $name,
                'enum' => new StringEnum($name, $group[0]['values'], $open, null),
                'keys' => array_values(array_unique($keys)),
            ];
        }, array_values($groups));
    }

    /**
     * @param list<array{string, string}> $classes Pairs of where a class comes from and its name.
     */
    private static function checkClassNames(array $classes): void
    {
        $taken = [];
        foreach ($classes as [$path, $name]) {
            $key = strtolower($name);
            if (!preg_match(self::IDENTIFIER, $name) || \in_array($key, self::RESERVED_WORDS, true)) {
                throw new GeneratorException("{$path}: `{$name}` can't be a PHP class name");
            }
            if (isset($taken[$key])) {
                throw new GeneratorException("{$path}: class `{$name}` clashes with {$taken[$key]}'s");
            }
            $taken[$key] = $path;
        }
    }

    private function classFile(string $name, Schema $schema): PhpFile
    {
        $required = array_fill_keys([...$schema->required, ...array_keys($this->tags[$name] ?? [])], true);
        $optional = array_diff_key($schema->properties, $required);
        $properties = array_intersect_key($schema->properties, $required) + $optional;
        if (\count($properties) === 1 && !isset($this->tags[$name][array_key_first($properties)])) {
            throw new GeneratorException("{$name}: Valinor would map the whole object into its only property");
        }
        $types = self::mapWithKeys(
            $properties,
            fn (string $property, Schema $definition): PhpType => $this->propertyType(
                $name,
                $property,
                $definition,
                !isset($optional[$property]),
            ),
        );
        $docs = array_map(
            static fn (string $property, PhpType $type): string => rtrim(
                "@param {$type->doc} \${$property} " . self::oneLine($properties[$property]->description),
            ),
            array_keys($types),
            array_values($types),
        );
        $interfaces = array_keys(array_filter($this->unions, static fn (Union $union): bool => $union->has($name)));

        [$file, $namespace] = self::file(self::MODELS);
        $class = $namespace->addClass($name)->setFinal()->setReadOnly();
        $class->setImplements(array_map(self::fqn(...), $interfaces));
        if ($schema->description) {
            $class->addComment($schema->description);
        }
        $constructor = $class->addMethod('__construct')->addComment(implode("\n", $docs));
        foreach ($types as $property => $type) {
            $parameter = $constructor->addPromotedParameter($property)->setType($type->native);
            if (isset($optional[$property])) {
                $default = $this->defaultValue($type, $optional[$property]->default, "{$name}.{$property}");
                $parameter->setDefaultValue($default);
            }
            if ($type->rawJson) {
                $parameter->addAttribute(RawJson::class);
                $namespace->addUse(RawJson::class);
            }
            foreach ($type->imports as $import) {
                $namespace->addUse($import);
            }
        }

        return $file;
    }

    private function propertyType(string $owner, string $property, Schema $schema, bool $required): PhpType
    {
        $path = "{$owner}.{$property}";
        if (!preg_match(self::IDENTIFIER, $property) || $property === 'this') {
            throw new GeneratorException("{$path}: not a valid PHP property name");
        }
        $tag = $this->tags[$owner][$property] ?? null;
        $type = $tag !== null ? PhpType::literal($tag) : $this->types->typeOf($schema, $path);

        return $required || $schema->default !== null ? $type : $type->nullable();
    }

    private function defaultValue(PhpType $type, mixed $default, string $path): mixed
    {
        if ($default === null || $type->enum === null) {
            return $default;
        }
        $case = \is_string($default) ? $this->enums[$type->enum]->cases()[$default] ?? null : null;

        return $case !== null
            ? new Literal("{$type->enum}::{$case}")
            : throw new GeneratorException("{$path}: the default isn't a {$type->enum} value");
    }

    private function enumFile(StringEnum $enum): PhpFile
    {
        [$file, $namespace] = self::file(self::MODELS);
        $type = $namespace->addEnum($enum->name)->setType('string');
        if ($enum->description) {
            $type->addComment($enum->description);
        }
        foreach ($enum->cases() as $value => $case) {
            $type->addCase($case, $value);
        }

        return $file;
    }

    private static function interfaceFile(Union $union): PhpFile
    {
        $sealed = '@phpstan-sealed ' . implode('|', [...array_values($union->variants), $union->unknown()]);
        [$file, $namespace] = self::file(self::MODELS);
        $interface = $namespace->addInterface($union->name);
        $interface->addComment(implode("\n\n", array_filter([$union->description, $sealed])));

        return $file;
    }

    private static function unknownFile(Union $union): PhpFile
    {
        [$file, $namespace] = self::file(self::MODELS);
        $namespace->addUse(JsonSerializable::class);
        $class = $namespace->addClass($union->unknown())
            ->setFinal()
            ->setReadOnly()
            ->setImplements([self::fqn($union->name), JsonSerializable::class])
            ->addComment("A `{$union->name}` whose `{$union->property}` this SDK version doesn't know.")
        ;
        $constructor = $class->addMethod('__construct')->addComment(
            "@phpstan-pure\n@param array<string, mixed> \$data The object as the API sent it, discriminator included.",
        );
        $constructor->addPromotedParameter($union->property)->setType('string');
        $constructor->addPromotedParameter('data')->setType('array');
        $class->addMethod('jsonSerialize')
            ->setReturnType('array')
            ->addComment('@return array<string, mixed>')
            ->setBody('return $this->data;')
        ;

        return $file;
    }

    private static function unknownEnumValueFile(): PhpFile
    {
        [$file, $namespace] = self::file(self::MODELS);
        $namespace->addUse(JsonSerializable::class);
        $class = $namespace->addClass(self::UNKNOWN_ENUM_VALUE)
            ->setFinal()
            ->setReadOnly()
            ->addImplement(JsonSerializable::class)
            ->addComment("An enum value this SDK version doesn't know. Encodes to JSON as the bare value, like a case.")
        ;
        $class->addMethod('__construct')->addComment('@phpstan-pure')->addPromotedParameter('value')->setType('string');
        $class->addMethod('jsonSerialize')->setReturnType('string')->setBody('return $this->value;');

        return $file;
    }

    private function mappingFile(): PhpFile
    {
        $openEnums = array_keys(array_filter($this->enums, static fn (StringEnum $enum): bool => $enum->open));
        $unions = array_values($this->unions);
        $models = [
            ...$openEnums,
            ...($openEnums ? [self::UNKNOWN_ENUM_VALUE] : []),
            ...array_keys($this->unions),
            ...array_map(static fn (Union $union): string => $union->unknown(), $unions),
            ...array_merge(...array_map(static fn (Union $union): array => array_values($union->variants), $unions)),
        ];

        [$file, $namespace] = self::file(self::MAPPING);
        $namespace->addUse(MapperBuilder::class);
        if ($unions) {
            $namespace->addUse(LogicException::class);
        }
        foreach (array_unique($models) as $model) {
            $namespace->addUse(self::fqn($model));
        }
        $class = $namespace->addClass('ModelMapping')->setFinal()->addComment(<<<'DOC'
            Valinor can't choose between an enum and UnknownEnumValue for a known value without a converter per enum.
            The converters are global: free-form properties carry #[RawJson] to stay out of their reach.

            @internal
            DOC);
        $configure = $class->addMethod('configure')->setStatic()->setReturnType(MapperBuilder::class);
        $configure->addParameter('builder')->setType(MapperBuilder::class);
        $links = array_map(self::enumConverter(...), $openEnums);
        foreach ($unions as $union) {
            $links[] = self::addUnionConverter($class, $union);
        }
        $configure->setBody('return $builder' . implode('', array_map(
            static fn (string $link): string => "\n\t" . str_replace("\n", "\n\t", $link),
            $links,
        )) . "\n;");

        return $file;
    }

    private static function enumConverter(string $enum): string
    {
        return <<<PHP
            ->registerConverter(
            \tstatic fn (string \$value): {$enum}|UnknownEnumValue
            \t\t=> {$enum}::tryFrom(\$value) ?? new UnknownEnumValue(\$value),
            )
            PHP;
    }

    /**
     * Adds the union's converter, which catches unknown discriminator values, and its variant resolver.
     *
     * @return string Their registration in `configure()`.
     */
    private static function addUnionConverter(ClassType $class, Union $union): string
    {
        $constant = strtoupper(implode('_', preg_split('/(?=[A-Z])/', lcfirst($union->name)) ?: [$union->name]));
        $converter = lcfirst($union->name);
        $resolver = "{$converter}Class";
        $variable = "\${$union->property}";
        $classes = array_map(static fn (string $class): Literal => new Literal("{$class}::class"), $union->variants);
        $class->addConstant($constant, $classes)->setPrivate();
        $key = var_export($union->property, true);

        $method = $class->addMethod($converter)->setPrivate()->setStatic()->setReturnType(self::fqn($union->name));
        $method->addParameter('value')->setType('array');
        $method->addParameter('next')->setType('callable');
        $method->addComment(<<<DOC
            @phpstan-pure
            @param array<string, mixed> \$value
            @param pure-callable(array<string, mixed>): {$union->name} \$next
            DOC);
        $method->setBody(<<<PHP
            \$tag = \$value[{$key}] ?? null;

            return \\is_string(\$tag) && !isset(self::{$constant}[\$tag])
            \t? new {$union->unknown()}(\$tag, \$value)
            \t: \$next(\$value);
            PHP);

        $method = $class->addMethod($resolver)->setPrivate()->setStatic()->setReturnType('string');
        $method->addParameter($union->property)->setType('string');
        $variants = implode('|', array_unique($union->variants));
        $method->addComment("@phpstan-pure\n@return class-string<{$variants}>");
        $method->setBody(<<<PHP
            return self::{$constant}[{$variable}]
            \t?? throw new LogicException("No {$union->name} variant for {$union->property} `{{$variable}}`.");
            PHP);

        return "->registerConverter(self::{$converter}(...))\n->infer({$union->name}::class, self::{$resolver}(...))";
    }

    /**
     * @return array{PhpFile, PhpNamespace}
     */
    private static function file(string $namespace): array
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        return [$file, $file->addNamespace($namespace)];
    }

    private static function oneLine(?string $text): string
    {
        return trim(preg_replace('/\s+/', ' ', $text ?? '') ?? '');
    }

    /**
     * array_map that passes the key along and keeps it.
     *
     * @template T
     * @template R
     * @param array<string, T> $array
     * @param callable(string, T): R $callback
     * @return array<string, R>
     */
    private static function mapWithKeys(array $array, callable $callback): array
    {
        return array_combine(array_keys($array), array_map($callback, array_keys($array), array_values($array)));
    }
}
