<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools;

use DateTimeImmutable;

/**
 * A model property's type, as a native declaration and as a PHPDoc type.
 */
final readonly class PhpType
{
    /**
     * @param string $native With fully-qualified class names, which nette shortens against the file's imports.
     * @param string $doc With short class names: every model shares one namespace.
     * @param string|null $enum The enum behind the type, which a default value must name a case of.
     * @param bool $rawJson A free-form object, which must bypass the enum converters.
     * @param list<class-string> $imports Classes outside the models' namespace that `$doc` names.
     */
    private function __construct(
        public string $native,
        public string $doc,
        public ?string $enum,
        public bool $rawJson,
        public array $imports,
    ) {
    }

    public static function scalar(string $type): self
    {
        return new self($type, $type, null, false, []);
    }

    public static function dateTime(): self
    {
        return new self(DateTimeImmutable::class, 'DateTimeImmutable', null, false, [DateTimeImmutable::class]);
    }

    public static function model(string $name): self
    {
        return new self(ModelGenerator::fqn($name), $name, null, false, []);
    }

    public static function openEnum(string $name): self
    {
        return new self(
            ModelGenerator::fqn($name) . '|' . ModelGenerator::fqn(ModelGenerator::UNKNOWN_ENUM_VALUE),
            "{$name}|" . ModelGenerator::UNKNOWN_ENUM_VALUE,
            $name,
            false,
            [],
        );
    }

    public static function literal(string $value): self
    {
        return new self('string', var_export($value, true), null, false, []);
    }

    public static function freeForm(): self
    {
        return new self('array', 'array<string, mixed>', null, true, []);
    }

    public static function listOf(self $item): self
    {
        return new self('array', "list<{$item->doc}>", null, false, $item->imports);
    }

    public static function mapOf(self $value): self
    {
        return new self('array', "array<string, {$value->doc}>", null, false, $value->imports);
    }

    /**
     * @param non-empty-list<self> $scalars
     */
    public static function scalarUnion(array $scalars): self
    {
        $type = implode('|', array_unique(array_map(static fn (self $scalar): string => $scalar->native, $scalars)));

        return self::scalar($type);
    }

    public function nullable(): self
    {
        if (str_starts_with($this->native, '?') || str_ends_with($this->native, '|null')) {
            return $this;
        }
        $native = str_contains($this->native, '|') ? "{$this->native}|null" : "?{$this->native}";

        return new self($native, "{$this->doc}|null", $this->enum, $this->rawJson, $this->imports);
    }
}
