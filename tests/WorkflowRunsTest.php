<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

final class WorkflowRunsTest extends SdkTestCase
{
    public function testGetWorkflowRunIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['id' => 'wfr_1'])]);

        $pj->getWorkflowRun('wfr_1');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/workflowruns/wfr_1', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
    }

    public function testRunWorkflowPostsParamsAsJsonBody(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['id' => 'wfr_1'])]);

        $pj->runWorkflow('pipeline', 7, inputs: ['q' => 'hello'], priority: 'onsite', envVars: ['K' => 'v']);

        $request = $this->lastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/workflows/pipeline/7/runs', $request->getUri()->getPath());
        self::assertEquals([
            'envVars' => ['K' => 'v'],
            'inputs' => ['q' => 'hello'],
            'priority' => 'onsite',
        ], $this->jsonBody($request));
    }
}
