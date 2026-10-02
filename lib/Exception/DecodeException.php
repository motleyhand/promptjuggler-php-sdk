<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Exception;

use Exception;
use Throwable;

/**
 * Thrown when the API replied with a success status but the body didn't decode into the
 * expected model. The request succeeded, so retrying a run starts a second one.
 */
final class DecodeException extends Exception implements PromptJugglerException
{
    public function __construct(string $message, Throwable $previous)
    {
        parent::__construct($message, 0, $previous);
    }
}
