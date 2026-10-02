<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum ModelParamsReasoningEffort: string
{
    case None = 'none';
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Xhigh = 'xhigh';
    case Max = 'max';
}
