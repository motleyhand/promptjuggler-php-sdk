<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class Model extends Enum
{
    public const GPT55 = 'gpt-5.5';
    public const GPT55_PRO = 'gpt-5.5-pro';
    public const GPT54 = 'gpt-5.4';
    public const GPT54_MINI = 'gpt-5.4-mini';
    public const GPT54_NANO = 'gpt-5.4-nano';
    public const GPT54_PRO = 'gpt-5.4-pro';
    public const GPT52 = 'gpt-5.2';
    public const GPT52_PRO = 'gpt-5.2-pro';
    public const GPT51 = 'gpt-5.1';
    public const GPT41 = 'gpt-4.1';
    public const GPT41_MINI = 'gpt-4.1-mini';
    public const GPT4O = 'gpt-4o';
    public const GPT4O_MINI = 'gpt-4o-mini';
    public const GEMINI31_PRO_PREVIEW = 'gemini-3.1-pro-preview';
    public const GEMINI35_FLASH = 'gemini-3.5-flash';
    public const GEMINI3_FLASH_PREVIEW = 'gemini-3-flash-preview';
    public const GEMINI31_FLASH_LITE = 'gemini-3.1-flash-lite';
    public const GEMINI25_PRO = 'gemini-2.5-pro';
    public const GEMINI25_FLASH = 'gemini-2.5-flash';
    public const GEMINI25_FLASH_LITE = 'gemini-2.5-flash-lite';
    public const CLAUDE_OPUS48 = 'claude-opus-4-8';
    public const CLAUDE_OPUS47 = 'claude-opus-4-7';
    public const CLAUDE_OPUS46 = 'claude-opus-4-6';
    public const CLAUDE_OPUS45 = 'claude-opus-4-5';
    public const CLAUDE_SONNET46 = 'claude-sonnet-4-6';
    public const CLAUDE_SONNET45 = 'claude-sonnet-4-5';
    public const CLAUDE_HAIKU45 = 'claude-haiku-4-5';
}
