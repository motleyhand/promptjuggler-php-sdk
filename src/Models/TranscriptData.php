<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\Mapping\RawJson;

/**
 * An emit-tool payload, in the position it was produced.
 */
final readonly class TranscriptData implements TranscriptItem
{
    /**
     * @param string $tool The emit tool that produced this payload.
     * @param array<string, mixed> $payload The payload — the tool-call arguments, verbatim.
     * @param 'data' $type
     */
    public function __construct(
        public string $tool,
        #[RawJson]
        public array $payload,
        public string $type,
    ) {
    }
}
