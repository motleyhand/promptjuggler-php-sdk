<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

final readonly class MediaType
{
    public function __construct(
        public ?Schema $schema = null,
    ) {
    }
}
