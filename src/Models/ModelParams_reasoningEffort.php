<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class ModelParams_reasoningEffort extends OpenEnum
{
    public const NONE = 'none';
    public const LOW = 'low';
    public const MEDIUM = 'medium';
    public const HIGH = 'high';
    public const XHIGH = 'xhigh';
    public const MAX = 'max';
}
