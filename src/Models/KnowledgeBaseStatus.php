<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class KnowledgeBaseStatus extends OpenEnum
{
    public const PENDING = 'pending';
    public const READY = 'ready';
    public const FAILED = 'failed';
}
