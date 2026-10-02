<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

final readonly class ModelCost
{
    public function __construct(
        public float $input,
        public float $cachedInput,
        public float $cacheWrite,
        public float $output,
        public float $webSearch,
        public float $total,
    ) {
    }
}
