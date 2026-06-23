<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class ServiceTier extends Enum {
    public const AUTO = "auto";
    public const DEFAULT = "default";
    public const FLEX = "flex";
    public const PRIORITY = "priority";
}
