<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * A tool the model used: its name and how the call ended.
 */
final readonly class TranscriptTool implements TranscriptItem
{
    /**
     * @param string $name Tool name, as the model called it.
     * @param ToolStatus|UnknownEnumValue $status How the call ended.
     * @param list<string> $queries Search queries the model ran. Only ever populated by the built-in web_search tool.
     * @param list<Citation> $citations Sources this call returned. Only ever populated by the built-in web_search tool.
     * @param 'tool' $type
     */
    public function __construct(
        public string $name,
        public ToolStatus|UnknownEnumValue $status,
        public array $queries,
        public array $citations,
        public string $type,
    ) {
    }
}
