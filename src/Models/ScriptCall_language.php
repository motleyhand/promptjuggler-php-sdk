<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ScriptCall_language extends Enum
{
    public const PYTHON = 'python';
    public const JAVASCRIPT = 'javascript';
}
