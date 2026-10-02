<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

final readonly class RunCost
{
    public function __construct(
        public ModelCost $success,
        public ModelCost $retries,
        public float $total,
    ) {
    }
}
