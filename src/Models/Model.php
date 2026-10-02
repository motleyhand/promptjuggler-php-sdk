<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

enum Model: string
{
    case Gpt6Astra = 'gpt-6-astra';
    case Gpt6Sol = 'gpt-6-sol';
    case Gpt6Luna = 'gpt-6-luna';
    case Gpt5_6Sol = 'gpt-5.6-sol';
    case Gpt5_6Terra = 'gpt-5.6-terra';
    case Gpt5_6Luna = 'gpt-5.6-luna';
    case Gpt5_5 = 'gpt-5.5';
    case Gpt5_5Pro = 'gpt-5.5-pro';
    case Gpt5_4 = 'gpt-5.4';
    case Gpt5_4Mini = 'gpt-5.4-mini';
    case Gpt5_4Nano = 'gpt-5.4-nano';
    case Gpt5_4Pro = 'gpt-5.4-pro';
    case Gpt5_2 = 'gpt-5.2';
    case Gpt5_2Pro = 'gpt-5.2-pro';
    case Gpt5_1 = 'gpt-5.1';
    case Gpt4_1 = 'gpt-4.1';
    case Gpt4_1Mini = 'gpt-4.1-mini';
    case Gpt4o = 'gpt-4o';
    case Gpt4oMini = 'gpt-4o-mini';
    case Gemini3_1ProPreview = 'gemini-3.1-pro-preview';
    case Gemini3_8Flash = 'gemini-3.8-flash';
    case Gemini3_7Flash = 'gemini-3.7-flash';
    case Gemini3_6Flash = 'gemini-3.6-flash';
    case Gemini3_5Flash = 'gemini-3.5-flash';
    case Gemini3FlashPreview = 'gemini-3-flash-preview';
    case Gemini3_5FlashLite = 'gemini-3.5-flash-lite';
    case Gemini3_1FlashLite = 'gemini-3.1-flash-lite';
    case Gemini2_5Pro = 'gemini-2.5-pro';
    case Gemini2_5Flash = 'gemini-2.5-flash';
    case Gemini2_5FlashLite = 'gemini-2.5-flash-lite';
    case ClaudeFable5_1 = 'claude-fable-5-1';
    case ClaudeFable5 = 'claude-fable-5';
    case ClaudeOpus5_5 = 'claude-opus-5-5';
    case ClaudeOpus5 = 'claude-opus-5';
    case ClaudeOpus4_8 = 'claude-opus-4-8';
    case ClaudeOpus4_7 = 'claude-opus-4-7';
    case ClaudeOpus4_6 = 'claude-opus-4-6';
    case ClaudeOpus4_5 = 'claude-opus-4-5';
    case ClaudeSonnet5 = 'claude-sonnet-5';
    case ClaudeSonnet4_6 = 'claude-sonnet-4-6';
    case ClaudeSonnet4_5 = 'claude-sonnet-4-5';
    case ClaudeHaiku4_5 = 'claude-haiku-4-5';
}
