<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Exception;

use Exception;
use Throwable;

/**
 * Thrown when the API responds with an error status. Carries the HTTP status code
 * and the server's error message; the original Kiota exception is the `previous`.
 */
final class ApiException extends Exception implements PromptJugglerException
{
    public function __construct(
        string $message,
        public readonly ?int $statusCode,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, 0, $previous);
    }
}
