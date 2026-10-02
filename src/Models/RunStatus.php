<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum RunStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Failed = 'failed';
}
