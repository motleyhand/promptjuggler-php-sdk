<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

final class PromptsTest extends SdkTestCase
{
    public function testGetPromptWithIntegerVersionIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['slug' => 'greeting'])]);

        $pj->getPrompt('greeting', 42);

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/prompts/greeting/42', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
    }

    public function testGetPromptAcceptsStringTagAsVersion(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['slug' => 'greeting'])]);

        $pj->getPrompt('greeting', 'production');

        self::assertSame('/api/v1/prompts/greeting/production', $this->lastRequest()->getUri()->getPath());
    }

    public function testRunPromptPostsParamsAsJsonBody(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['id' => 'run_1'])]);

        $pj->runPrompt(
            'greeting',
            42,
            inputs: ['topic' => 'AI safety'],
            priority: 'low',
            thread: 'thread_1',
            environment: 'staging',
            envVars: ['MY_KEY' => 'sk-x'],
            metadata: ['user_id' => '42'],
            channel: 'main',
        );

        $request = $this->lastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/prompts/greeting/42/runs', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));

        self::assertEquals([
            'channel' => 'main',
            'environment' => 'staging',
            'envVars' => ['MY_KEY' => 'sk-x'],
            'inputs' => ['topic' => 'AI safety'],
            'metadata' => ['user_id' => '42'],
            'priority' => 'low',
            'thread' => 'thread_1',
        ], $this->jsonBody($request));
    }
}
