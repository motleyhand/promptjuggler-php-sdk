<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Mapping;

use Attribute;
use CuyZ\Valinor\Mapper\AsConverter;

/**
 * Maps a free-form JSON object as is. The generated converters are global: without this, they would
 * turn the payload's strings into enum values and its nested objects into union variants.
 *
 * @internal
 */
#[AsConverter]
// Valinor maps promoted properties through their constructor parameters, and skips attributes that can't target them.
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
final class RawJson
{
    /**
     * @param array<string, mixed> $value
     * @return array<string, mixed>
     */
    public function map(array $value): array
    {
        return $value;
    }
}
