<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum Memory: string
{
    case Stateless = 'stateless';
    case ReadOnly = 'read_only';
    case ReadWrite = 'read_write';
    case WriteOnly = 'write_only';
}
