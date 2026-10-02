<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Exception;

use Exception;

/**
 * Thrown when the API responds with an error status. Carries the HTTP status code
 * and the server's error message, or the status line when the body has none.
 */
final class ApiException extends Exception implements PromptJugglerException
{
    public function __construct(
        string $message,
        public readonly int $statusCode,
    ) {
        parent::__construct($message);
    }
}
