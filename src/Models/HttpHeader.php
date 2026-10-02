<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

final readonly class HttpHeader
{
    public function __construct(
        public string $key,
        public string $value,
    ) {
    }
}
