<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use InvalidArgumentException;

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

    // The API adds fields and enum values without a major version, so a published client must
    // decode a response carrying ones it doesn't know.
    public function testGetPromptDecodesFieldsAndEnumValuesNewerThanTheSdk(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([
            'id' => '550e8400-e29b-41d4-a716-446655440000',
            'promptId' => '550e8400-e29b-41d4-a716-446655440001',
            'memory' => 'stateless',
            'provider' => 'openai',
            'model' => 'gpt-9',
            'modelParams' => ['reasoningEffort' => 'ultra'],
            'responseFormat' => ['type' => 'text', 'addedLater' => 1],
            'messages' => [],
            'tools' => [[
                'type' => 'http',
                'name' => 'lookup',
                'url' => 'https://example.com',
                'method' => 'QUERY',
                'paramsSchema' => '{}',
                'failFast' => false,
            ]],
            'addedLater' => true,
        ])]);

        $prompt = $pj->getPrompt('greeting', 'production');

        self::assertSame('gpt-9', $prompt->getModel()?->value());
        self::assertSame('ultra', $prompt->getModelParams()?->getReasoningEffort()?->value());
        self::assertSame('QUERY', $prompt->getTools()[0]->getHttpCall()?->getMethod()?->value());
    }

    public function testRunPromptRejectsUnknownPriorityBeforeSending(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['id' => 'run_1'])]);

        $this->expectException(InvalidArgumentException::class);
        try {
            $pj->runPrompt('greeting', 42, inputs: [], priority: 'urgent');
        } finally {
            self::assertSame([], $this->history);
        }
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
