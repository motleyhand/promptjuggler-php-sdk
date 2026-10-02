<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Exception;

use Exception;
use Throwable;

/**
 * Thrown when the request got no complete response (DNS failure, timeout, a dropped connection).
 */
final class NetworkException extends Exception implements PromptJugglerException
{
    public function __construct(string $message, Throwable $previous)
    {
        parent::__construct($message, 0, $previous);
    }
}
