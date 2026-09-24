<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class Memory extends OpenEnum
{
    public const STATELESS = 'stateless';
    public const READ_ONLY = 'read_only';
    public const READ_WRITE = 'read_write';
    public const WRITE_ONLY = 'write_only';
}
