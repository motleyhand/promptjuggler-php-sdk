<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

final readonly class RequestBody
{
    /**
     * @param array<string, MediaType> $content By media type.
     */
    public function __construct(
        public array $content,
    ) {
    }
}
