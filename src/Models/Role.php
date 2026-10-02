<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum Role: string
{
    case Assistant = 'assistant';
    case User = 'user';
}
