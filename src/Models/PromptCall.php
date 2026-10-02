<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Tool to invoke another prompt.
 */
final readonly class PromptCall implements Tool
{
    /**
     * @param VersionRef $versionRef Referencing the prompt revision either by id or version number or tag.
     * @param string $name The tool’s name.
     * @param bool $failFast Whether to stop processing if a tool call fails.
     * @param 'prompt' $type
     * @param string|null $description The tool’s description.
     */
    public function __construct(
        public VersionRef $versionRef,
        public string $name,
        public bool $failFast,
        public string $type,
        public ?string $description = null,
    ) {
    }
}
