<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Webhook;

/**
 * Verifies the `PromptJuggler-Signature` header on incoming webhooks.
 *
 * The header is `t={timestamp},v1={signature}`, where the signature is an
 * HMAC-SHA256 of `{timestamp}.{raw_body}` keyed with your webhook secret. Always
 * verify against the *raw* request body, before any JSON decoding.
 */
final class WebhookSignature
{
    public static function isValid(
        string $payload,
        string $signatureHeader,
        string $secret,
        int $tolerance = 300,
        ?int $now = null,
    ): bool {
        $parsed = self::parse($signatureHeader);
        if ($parsed === null) {
            return false;
        }
        [$timestamp, $signature] = $parsed;

        $now ??= time();
        if (abs($now - $timestamp) > $tolerance) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);

        return hash_equals($expected, $signature);
    }

    /**
     * @return array{0: int, 1: string}|null timestamp and v1 signature, or null if malformed
     */
    private static function parse(string $header): ?array
    {
        $fields = [];
        foreach (explode(',', $header) as $segment) {
            [$key, $value] = array_pad(explode('=', $segment, 2), 2, null);
            if ($value !== null) {
                $fields[$key] = $value;
            }
        }

        if (!isset($fields['t'], $fields['v1']) || !ctype_digit($fields['t'])) {
            return null;
        }

        return [(int) $fields['t'], $fields['v1']];
    }
}
