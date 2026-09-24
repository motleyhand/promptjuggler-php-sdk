<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class Role extends OpenEnum
{
    public const ASSISTANT = 'assistant';
    public const USER = 'user';
}
