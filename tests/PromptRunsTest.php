<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use PromptJuggler\Client\Models\RunStatus;

final class PromptRunsTest extends SdkTestCase
{
    public function testGetPromptRunIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRunJson())]);

        $run = $pj->getPromptRun('run_1');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/promptruns/run_1', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
        self::assertSame(RunStatus::Completed, $run->status);
        self::assertSame('Hello there!', $run->output);
    }

    public function testGetPromptRunEncodesTheId(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRunJson())]);

        $pj->getPromptRun('../run');

        self::assertSame('/api/v1/promptruns/..%2Frun', $this->lastRequest()->getUri()->getPath());
    }
}
