<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Psr7\Response;
use PromptJuggler\Client\Exception\ApiException;

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
}
