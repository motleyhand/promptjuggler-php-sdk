<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Exception;

use Throwable;

/**
 * Marker for every exception the SDK throws, so callers can catch the whole SDK
 * surface with a single `catch (PromptJugglerException $e)`.
 */
interface PromptJugglerException extends Throwable
{
}
