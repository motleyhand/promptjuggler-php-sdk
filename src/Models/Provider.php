<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use PromptJuggler\Client\OpenEnum;

class Provider extends OpenEnum
{
    public const OPENAI = 'openai';
    public const GEMINI = 'gemini';
    public const ANTHROPIC = 'anthropic';
}
