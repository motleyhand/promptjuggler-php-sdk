<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum ToolStatus: string
{
    case Ok = 'ok';
    case Error = 'error';
    case Pending = 'pending';
}
