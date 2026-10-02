<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use JsonSerializable;

/**
 * An enum value this SDK version doesn't know. Encodes to JSON as the bare value, like a case.
 */
final readonly class UnknownEnumValue implements JsonSerializable
{
    /**
     * @phpstan-pure
     */
    public function __construct(
        public string $value,
    ) {
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
