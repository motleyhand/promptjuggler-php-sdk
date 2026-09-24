<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class ServiceTier extends OpenEnum
{
    public const AUTO = 'auto';
    public const DEFAULT = 'default';
    public const FLEX = 'flex';
    public const PRIORITY = 'priority';
}
