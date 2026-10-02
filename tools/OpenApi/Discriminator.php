<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

final readonly class Discriminator
{
    /**
     * @param array<string, string> $mapping `$ref`s by discriminator value.
     */
    public function __construct(
        public string $propertyName,
        public array $mapping = [],
    ) {
    }
}
