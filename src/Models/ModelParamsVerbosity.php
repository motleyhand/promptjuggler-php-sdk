<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum ModelParamsVerbosity: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
}
