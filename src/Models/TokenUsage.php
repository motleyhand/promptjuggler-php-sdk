<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

final readonly class TokenUsage
{
    public function __construct(
        public int $input,
        public int $inputCached,
        public int $output,
        public int $reasoning,
        public int $total,
        public ServiceTier|UnknownEnumValue|null $serviceTier = null,
        public int $inputCacheWrite = 0,
    ) {
    }
}
