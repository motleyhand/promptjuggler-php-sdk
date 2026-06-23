<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class Provider extends Enum {
    public const OPENAI = "openai";
    public const GEMINI = "gemini";
    public const ANTHROPIC = "anthropic";
}
