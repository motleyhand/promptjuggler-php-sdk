<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools;

use PromptJuggler\Client\Tools\OpenApi\Schema;
use PromptJuggler\Client\Tools\OpenApi\Spec;

/**
 * Maps a property's schema to its PHP type, and checks a response body's.
 */
final readonly class TypeMapper
{
    /**
     * @param array<string, StringEnum> $enums By name.
     * @param array<string, string> $inlineEnums Inline enum names, by `Schema.property`.
     */
    public function __construct(
        private Spec $spec,
        private array $enums,
        private array $inlineEnums,
    ) {
    }

    /**
     * @param string $path `Schema.property`.
     */
    public function typeOf(Schema $schema, string $path): PhpType
    {
        return $this->map($schema, $path, $this->inlineEnums[$path] ?? null);
    }

    /**
     * Rejects a response body that can't be mapped. The hand-written facade names its type.
     */
    public function checkResponseBody(Schema $schema, string $where): void
    {
        $this->nested($schema, $where);
    }

    private function map(Schema $schema, string $path, ?string $inlineEnum): PhpType
    {
        if ($schema->ref !== null) {
            $name = $this->spec->schemaName($schema->ref, $path);

            return isset($this->enums[$name]) ? PhpType::openEnum($name) : PhpType::model($name);
        }
        if ($schema->oneOf !== null) {
            if ($schema->discriminator) {
                throw new GeneratorException("{$path}: a discriminated union needs a component schema");
            }

            return $this->oneOf($schema->oneOf, $path);
        }
        $types = $schema->types();
        $nonNull = array_values(array_diff($types, ['null']));
        if (\count($nonNull) !== 1) {
            $list = implode(', ', $nonNull);

            throw new GeneratorException("{$path}: needs exactly one non-null type, has [{$list}]");
        }
        if ($schema->enum !== null && $nonNull[0] !== 'string') {
            throw new GeneratorException("{$path}: an enum needs `type: string`");
        }
        $type = match (true) {
            $schema->enum !== null => PhpType::openEnum(
                $inlineEnum ?? throw new GeneratorException("{$path}: an inline enum must be a property's own schema"),
            ),
            $nonNull[0] === 'string' && $schema->format === 'date-time' => PhpType::dateTime(),
            $nonNull[0] === 'string' => PhpType::scalar('string'),
            $nonNull[0] === 'integer' => PhpType::scalar('int'),
            $nonNull[0] === 'number' => PhpType::scalar('float'),
            $nonNull[0] === 'boolean' => PhpType::scalar('bool'),
            $nonNull[0] === 'array' => PhpType::listOf($this->nested($schema->items, "{$path}.items")),
            $nonNull[0] === 'object' => $this->object($schema, $path),
            default => throw new GeneratorException("{$path}: unsupported type `{$nonNull[0]}`"),
        };

        return \count($types) > 1 ? $type->nullable() : $type;
    }

    /**
     * @param list<Schema> $members
     */
    private function oneOf(array $members, string $path): PhpType
    {
        $nonNull = array_values(array_filter($members, static fn (Schema $member): bool => !$member->isNull()));
        $scalars = array_filter($nonNull, static fn (Schema $member): bool => $member->isScalar());
        $type = match (true) {
            \count($nonNull) === 1 => $this->map($nonNull[0], "{$path}.oneOf", null),
            $nonNull && $scalars === $nonNull => PhpType::scalarUnion(array_map(
                fn (Schema $member): PhpType => $this->map($member, "{$path}.oneOf", null),
                $nonNull,
            )),
            default => throw new GeneratorException(
                "{$path}: a oneOf without discriminator must be scalars, or one schema and null",
            ),
        };

        return \count($nonNull) < \count($members) ? $type->nullable() : $type;
    }

    private function object(Schema $schema, string $path): PhpType
    {
        if ($schema->properties) {
            throw new GeneratorException("{$path}: an object with properties needs a component schema");
        }

        return $schema->additionalProperties instanceof Schema
            ? PhpType::mapOf($this->nested($schema->additionalProperties, "{$path}.additionalProperties"))
            : PhpType::freeForm();
    }

    private function nested(?Schema $schema, string $path): PhpType
    {
        $type = $this->map($schema ?? throw new GeneratorException("{$path}: missing"), $path, null);
        if ($type->rawJson) {
            throw new GeneratorException("{$path}: a free-form object must be a property's own schema");
        }

        return $type;
    }
}
