<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum ServiceTier: string
{
    case Auto = 'auto';
    case Default = 'default';
    case Flex = 'flex';
    case Priority = 'priority';
}
