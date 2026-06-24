<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

final class PromptRunsTest extends SdkTestCase
{
    public function testGetPromptRunIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([
            'id' => 'run_1',
            'status' => 'completed',
            'createdAt' => '2026-06-23T12:00:00Z',
        ])]);

        $pj->getPromptRun('run_1');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/promptruns/run_1', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
    }
}
