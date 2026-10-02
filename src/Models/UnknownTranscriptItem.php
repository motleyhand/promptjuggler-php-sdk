<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use JsonSerializable;

/**
 * A `TranscriptItem` whose `type` this SDK version doesn't know.
 */
final readonly class UnknownTranscriptItem implements TranscriptItem, JsonSerializable
{
    /**
     * @phpstan-pure
     * @param array<string, mixed> $data The object as the API sent it, discriminator included.
     */
    public function __construct(
        public string $type,
        public array $data,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
