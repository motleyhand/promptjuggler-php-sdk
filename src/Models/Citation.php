<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * A source the model cited.
 */
final readonly class Citation
{
    public function __construct(
        public string $title,
        public string $url,
    ) {
    }
}
