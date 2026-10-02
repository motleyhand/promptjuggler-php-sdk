<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum KnowledgeBaseStatus: string
{
    case Pending = 'pending';
    case Ready = 'ready';
    case Failed = 'failed';
}
