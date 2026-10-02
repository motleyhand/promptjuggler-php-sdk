<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum KnowledgeDocumentStatus: string
{
    case Pending = 'pending';
    case Sealed = 'sealed';
    case Ready = 'ready';
    case Failed = 'failed';
}
