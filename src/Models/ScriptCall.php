<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Call custom Python or JavaScript function.
 */
final readonly class ScriptCall implements Tool
{
    /**
     * @param ScriptCallLanguage|UnknownEnumValue $language The language of the script to execute.
     * @param string $code The script that this tool executes.
     * @param string $name The tool’s name.
     * @param bool $failFast Whether to stop processing if a tool call fails.
     * @param 'script' $type
     * @param string|null $description The tool’s description.
     */
    public function __construct(
        public ScriptCallLanguage|UnknownEnumValue $language,
        public string $code,
        public string $name,
        public bool $failFast,
        public string $type,
        public ?string $description = null,
    ) {
    }
}
