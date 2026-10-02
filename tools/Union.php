<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools;

/**
 * A discriminated union: a sealed interface, its variant classes, and a class for the discriminator values this SDK
 * version doesn't know.
 */
final readonly class Union
{
    /**
     * @param array<string, string> $variants Variant class names, by discriminator value.
     */
    public function __construct(
        public string $name,
        public ?string $description,
        public string $property,
        public array $variants,
    ) {
    }

    public function unknown(): string
    {
        return "Unknown{$this->name}";
    }

    public function has(string $class): bool
    {
        return \in_array($class, $this->variants, true);
    }
}
