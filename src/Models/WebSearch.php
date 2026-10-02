<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Built-in web search.
 */
final readonly class WebSearch implements Tool
{
    /**
     * @param 'web_search' $type
     * @param list<string>|null $allowedDomains
     */
    public function __construct(
        public string $type,
        public ?array $allowedDomains = null,
    ) {
    }
}
