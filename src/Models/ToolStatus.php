<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ToolStatus extends Enum
{
    public const OK = 'ok';
    public const ERROR = 'error';
    public const PENDING = 'pending';
}
