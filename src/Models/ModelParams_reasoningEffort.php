<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ModelParams_reasoningEffort extends Enum {
    public const NONE = "none";
    public const MINIMAL = "minimal";
    public const LOW = "low";
    public const MEDIUM = "medium";
    public const HIGH = "high";
    public const XHIGH = "xhigh";
    public const MAX = "max";
}
