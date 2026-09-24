<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class ModelParams_verbosity extends OpenEnum
{
    public const LOW = 'low';
    public const MEDIUM = 'medium';
    public const HIGH = 'high';
}
