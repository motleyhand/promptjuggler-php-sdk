<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

final class StreamTokensTest extends SdkTestCase
{
    // Untyped: the SDK supports PHP ^8.2, and typed class constants need 8.3.
    private const THREAD = '0198f0e2-9c3a-7c1d-8f4b-2a6d5e7c9b10';

    public function testCreateStreamTokenIssuesAuthorizedPostRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([
            'token' => 'jwt-value',
            'expiresAt' => '2026-01-01T00:00:00+00:00',
            'url' => 'https://stream.promptjuggler.com/stream/' . self::THREAD,
        ])]);

        $pj->createStreamToken(self::THREAD);

        $request = $this->lastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/threads/' . self::THREAD . '/stream-token', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
    }

    public function testCreateStreamTokenReturnsTokenAndResolvedStreamUrl(): void
    {
        $url = 'https://stream.promptjuggler.com/stream/' . self::THREAD;
        $pj = $this->client('sk-test', [self::jsonResponse([
            'token' => 'jwt-value',
            'expiresAt' => '2026-01-01T00:00:00+00:00',
            'url' => $url,
        ])]);

        $response = $pj->createStreamToken(self::THREAD);

        self::assertSame('jwt-value', $response->getToken());
        self::assertSame($url, $response->getUrl());
    }
}
