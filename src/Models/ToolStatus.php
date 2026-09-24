<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class ToolStatus extends OpenEnum
{
    public const OK = 'ok';
    public const ERROR = 'error';
    public const PENDING = 'pending';
}
