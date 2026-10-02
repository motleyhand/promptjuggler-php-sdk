<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Emit a schema-validated payload: the arguments are the result.
 */
final readonly class Emit implements Tool
{
    /**
     * @param string $paramsSchema JSON schema of the payload this tool emits.
     * @param string $name The tool’s name.
     * @param bool $failFast Whether to stop processing if a tool call fails.
     * @param 'emit' $type
     * @param string|null $description The tool’s description.
     */
    public function __construct(
        public string $paramsSchema,
        public string $name,
        public bool $failFast,
        public string $type,
        public ?string $description = null,
    ) {
    }
}
