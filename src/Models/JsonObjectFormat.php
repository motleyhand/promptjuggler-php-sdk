<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * JSON object response format.
 */
final readonly class JsonObjectFormat implements ResponseFormat
{
    /**
     * @param 'json_object' $type
     */
    public function __construct(
        public string $type,
    ) {
    }
}
