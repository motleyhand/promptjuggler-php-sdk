<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use PHPUnit\Framework\TestCase;
use PromptJuggler\Client\Webhook\WebhookSignature;

final class WebhookSignatureTest extends TestCase
{
    private const SECRET = 'whsec_test';

    /** Sign a payload the way the server documents: HMAC-SHA256 over "{timestamp}.{body}". */
    private function header(string $payload, int $timestamp): string
    {
        $signature = hash_hmac('sha256', $timestamp . '.' . $payload, self::SECRET);

        return "t={$timestamp},v1={$signature}";
    }

    public function testAcceptsAGenuineSignature(): void
    {
        $payload = '{"event":"promptrun.finished"}';
        $now = 1_700_000_000;

        self::assertTrue(WebhookSignature::isValid($payload, $this->header($payload, $now), self::SECRET, now: $now));
    }

    public function testRejectsATamperedPayload(): void
    {
        $now = 1_700_000_000;
        $header = $this->header('{"event":"promptrun.finished"}', $now);

        self::assertFalse(WebhookSignature::isValid('{"event":"tampered"}', $header, self::SECRET, now: $now));
    }

    public function testRejectsAStaleTimestampOutsideTolerance(): void
    {
        $payload = '{}';
        $signedAt = 1_700_000_000;
        $header = $this->header($payload, $signedAt);

        self::assertFalse(WebhookSignature::isValid($payload, $header, self::SECRET, tolerance: 300, now: $signedAt + 600));
    }

    public function testRejectsAMalformedHeader(): void
    {
        self::assertFalse(WebhookSignature::isValid('{}', 'not-a-signature', self::SECRET, now: 1_700_000_000));
    }
}
