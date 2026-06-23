<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class Role extends Enum {
    public const ASSISTANT = "assistant";
    public const USER = "user";
}
