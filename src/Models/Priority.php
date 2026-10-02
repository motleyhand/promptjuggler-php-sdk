<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum Priority: string
{
    case Onsite = 'onsite';
    case Normal = 'normal';
    case Low = 'low';
}
