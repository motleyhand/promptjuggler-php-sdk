<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

/**
 * `description` is unused, but without it Valinor would map a response that has no `content` into
 * `$content`, as it does with every one-parameter class.
 */
final readonly class Response
{
    /**
     * @param array<string, MediaType> $content By media type.
     */
    public function __construct(
        public string $description,
        public array $content = [],
    ) {
    }
}
