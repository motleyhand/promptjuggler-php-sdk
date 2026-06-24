<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class Role extends Enum
{
    public const ASSISTANT = 'assistant';
    public const USER = 'user';
}
