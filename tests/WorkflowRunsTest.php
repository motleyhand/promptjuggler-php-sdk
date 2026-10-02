<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use PromptJuggler\Client\Models\Priority;

final class WorkflowRunsTest extends SdkTestCase
{
    public function testGetWorkflowRunIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::workflowRunJson())]);

        $run = $pj->getWorkflowRun('wfr_1');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/workflowruns/wfr_1', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
        self::assertSame(['answer' => '42'], $run->outputs);
    }

    public function testRunWorkflowPostsParamsAsJsonBody(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $created = $pj->runWorkflow(
            'pipeline',
            7,
            inputs: ['q' => 'hello'],
            priority: Priority::Onsite,
            envVars: ['K' => 'v'],
        );

        $request = $this->lastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/workflows/pipeline/7/runs', $request->getUri()->getPath());
        self::assertSame(
            '{"inputs":{"q":"hello"},"priority":"onsite","envVars":{"K":"v"}}',
            $this->rawBody($request),
        );
        self::assertSame('0198f0e2-1111-7c1d-8f4b-2a6d5e7c9b10', $created->id);
    }
}
