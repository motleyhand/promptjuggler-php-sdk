<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\Mapping\RawJson;

/**
 * One emit-tool call: the tool name and its schema-validated payload.
 */
final readonly class EmittedItem
{
    /**
     * @param string $tool The emit tool that produced this payload.
     * @param array<string, mixed> $payload The payload — the tool-call arguments, verbatim.
     */
    public function __construct(
        public string $tool,
        #[RawJson]
        public array $payload,
    ) {
    }
}
