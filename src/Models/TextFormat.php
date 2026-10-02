<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Text response format.
 */
final readonly class TextFormat implements ResponseFormat
{
    /**
     * @param 'text' $type
     */
    public function __construct(
        public string $type,
    ) {
    }
}
