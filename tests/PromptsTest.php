<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use PromptJuggler\Client\Models\Priority;

final class PromptsTest extends SdkTestCase
{
    public function testGetPromptWithIntegerVersionIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRevisionJson())]);

        $prompt = $pj->getPrompt('greeting', 42);

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/prompts/greeting/42', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
        self::assertSame('application/json', $request->getHeaderLine('Accept'));
        self::assertSame('Answer briefly.', $prompt->systemInstruction);
    }

    public function testGetPromptAcceptsStringTagAsVersion(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRevisionJson())]);

        $pj->getPrompt('greeting', 'production');

        self::assertSame('/api/v1/prompts/greeting/production', $this->lastRequest()->getUri()->getPath());
    }

    public function testGetPromptEncodesPathSegments(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::promptRevisionJson())]);

        $pj->getPrompt('a/b c', 'v?1');

        self::assertSame('/api/v1/prompts/a%2Fb%20c/v%3F1', $this->lastRequest()->getUri()->getPath());
    }

    public function testRunPromptPostsParamsAsJsonBody(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $created = $pj->runPrompt(
            'greeting',
            42,
            inputs: ['topic' => 'AI safety'],
            priority: Priority::Low,
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
        self::assertSame('application/json', $request->getHeaderLine('Content-Type'));
        self::assertEquals([
            'channel' => 'main',
            'environment' => 'staging',
            'envVars' => ['MY_KEY' => 'sk-x'],
            'inputs' => ['topic' => 'AI safety'],
            'metadata' => ['user_id' => '42'],
            'priority' => 'low',
            'thread' => 'thread_1',
        ], $this->jsonBody($request));
        self::assertSame('0198f0e2-1111-7c1d-8f4b-2a6d5e7c9b10', $created->id);
        self::assertSame('0198f0e2-2222-7c1d-8f4b-2a6d5e7c9b10', $created->thread);
    }

    // The server applies its own defaults to what's absent; the SDK must not send the spec's.
    public function testRunPromptSendsOnlyTheArgumentsPassed(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $pj->runPrompt('g', 1, inputs: []);

        self::assertSame('{"inputs":{}}', $this->rawBody($this->lastRequest()));
    }

    public function testRunPromptSendsAnExplicitlyEmptyMap(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $pj->runPrompt('g', 1, inputs: ['topic' => 'AI'], envVars: []);

        self::assertSame('{"inputs":{"topic":"AI"},"envVars":{}}', $this->rawBody($this->lastRequest()));
    }

    public function testRunPromptSendsMetadataListValuesAsJsonArrays(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $pj->runPrompt('g', 1, inputs: [], metadata: ['user_id' => '42', 'tags' => ['a', 'b']]);

        self::assertSame(
            '{"inputs":{},"metadata":{"user_id":"42","tags":["a","b"]}}',
            $this->rawBody($this->lastRequest()),
        );
    }

    public function testRunPromptKeepsNumericMapKeysAsObjectKeys(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::createdRunJson())]);

        $pj->runPrompt('g', 1, inputs: ['0' => 'zero', '1' => 'one']);

        self::assertSame('{"inputs":{"0":"zero","1":"one"}}', $this->rawBody($this->lastRequest()));
    }
}
