<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * A block of assistant text.
 */
final readonly class TranscriptText implements TranscriptItem
{
    /**
     * @param string $content The assistant text.
     * @param list<Citation> $citations Sources cited in this block, deduplicated by URL. Empty unless the model cited any.
     * @param 'text' $type
     */
    public function __construct(
        public string $content,
        public array $citations,
        public string $type,
    ) {
    }
}
