<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class KnowledgeBaseStatus extends Enum
{
    public const PENDING = 'pending';
    public const READY = 'ready';
    public const FAILED = 'failed';
}
