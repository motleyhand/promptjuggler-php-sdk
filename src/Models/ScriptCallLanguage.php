<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum ScriptCallLanguage: string
{
    case Python = 'python';
    case Javascript = 'javascript';
}
