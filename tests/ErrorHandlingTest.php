<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PromptJuggler\Client\Exception\ApiException;
use PromptJuggler\Client\Exception\DecodeException;
use PromptJuggler\Client\Exception\NetworkException;
use PromptJuggler\Client\PromptJuggler;

final class ErrorHandlingTest extends SdkTestCase
{
    public function testApiErrorBecomesSdkApiExceptionWithStatusCode(): void
    {
        $pj = $this->client('sk-test', [new Response(404, ['Content-Type' => 'application/json'], (string) json_encode([
            'error' => 'not found',
        ]))]);

        try {
            $pj->getPromptRun('missing');
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame(404, $e->statusCode);
        }
    }

    public function testApiErrorExposesTheServerErrorMessage(): void
    {
        $pj = $this->client('sk-test', [new Response(403, ['Content-Type' => 'application/json'], (string) json_encode([
            'error' => 'Quota exceeded',
        ]))]);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Quota exceeded');
        $pj->getPromptRun('run_1');
    }

    public function testApiErrorExposesTheServerErrorMessageForAnyStatus(): void
    {
        $pj = $this->client('sk-test', [new Response(404, ['Content-Type' => 'application/json'], (string) json_encode([
            'error' => 'Prompt run not found',
        ]))]);

        try {
            $pj->getPromptRun('missing');
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame('Prompt run not found', $e->getMessage());
        }
    }

    public function testUndecodableSuccessBodyBecomesDecodeException(): void
    {
        $pj = $this->client('sk-test', [new Response(200, ['Content-Type' => 'application/json'], '{"id":')]);

        $this->expectException(DecodeException::class);
        $pj->getPrompt('greeting', 'production');
    }

    public function testMistypedEnumInSuccessBodyBecomesDecodeException(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['id' => 'run_1', 'status' => ['pending']])]);

        $this->expectException(DecodeException::class);
        $pj->getPromptRun('run_1');
    }

    public function testEmptySuccessBodyBecomesDecodeException(): void
    {
        $pj = $this->client('sk-test', [new Response(200)]);

        $this->expectException(DecodeException::class);
        $pj->getPromptRun('run_1');
    }

    public function testUnreadableErrorBodyKeepsTheErrorStatus(): void
    {
        $pj = $this->client('sk-test', [new Response(502, ['Content-Type' => 'text/html'], '<html>Bad Gateway</html>')]);

        try {
            $pj->uploadDocuments('docs', ['notes.txt' => 'hello']);
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame(502, $e->statusCode);
            self::assertSame('502 Bad Gateway', $e->getMessage());
        }
    }

    public function testConnectionFailureBecomesNetworkException(): void
    {
        $pj = $this->client('sk-test', [new ConnectException('Connection refused', new Request('GET', '/'))]);

        $this->expectException(NetworkException::class);
        $pj->getPromptRun('run_1');
    }

    public function testErrorStatusBecomesApiExceptionEvenWithAGuzzleClientThatThrowsOnIt(): void
    {
        // A plain Guzzle client throws on 4xx/5xx by default (http_errors).
        $pj = new PromptJuggler('sk-test', new Client(['handler' => HandlerStack::create(new MockHandler([
            new Response(404, ['Content-Type' => 'application/json'], '{"error":"not found"}'),
        ]))]));

        try {
            $pj->getPromptRun('missing');
            self::fail('Expected ApiException to be thrown');
        } catch (ApiException $e) {
            self::assertSame(404, $e->statusCode);
        }
    }
}
