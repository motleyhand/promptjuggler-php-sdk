<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum Provider: string
{
    case Openai = 'openai';
    case Gemini = 'gemini';
    case Anthropic = 'anthropic';
}
