<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class KnowledgeDocumentStatus extends Enum {
    public const PENDING = "pending";
    public const SEALED = "sealed";
    public const READY = "ready";
    public const FAILED = "failed";
}
