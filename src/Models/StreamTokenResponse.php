<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use DateTimeImmutable;

/**
 * A short-lived credential for subscribing to a thread's token stream.
 */
final readonly class StreamTokenResponse
{
    /**
     * @param string $token Bearer token for the streaming endpoint. Safe to hand to a browser — it grants read access to this one thread and nothing else.
     * @param DateTimeImmutable $expiresAt Timestamp when the token stops being accepted.
     * @param string $url Fully-resolved SSE endpoint for this thread. Connect here with the token as a Bearer credential.
     */
    public function __construct(
        public string $token,
        public DateTimeImmutable $expiresAt,
        public string $url,
    ) {
    }
}
