<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class CreatePromptRun_priority extends Enum
{
    public const ONSITE = 'onsite';
    public const NORMAL = 'normal';
    public const LOW = 'low';
}
