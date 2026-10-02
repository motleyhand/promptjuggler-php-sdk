<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use PromptJuggler\Client\PromptJuggler;
use Psr\Http\Message\RequestInterface;
use Throwable;

abstract class SdkTestCase extends TestCase
{
    /** @var list<array{request: RequestInterface}> */
    protected array $history = [];

    /**
     * Build a facade whose HTTP layer is a Guzzle MockHandler returning the given
     * canned responses, recording every outgoing request into $this->history.
     *
     * @param list<Response|Throwable> $responses
     */
    protected function client(string $apiKey, array $responses, ?string $baseUrl = null): PromptJuggler
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $stack->push(Middleware::history($this->history));
        $http = new Client(['handler' => $stack]);

        return $baseUrl === null ? new PromptJuggler($apiKey, $http) : new PromptJuggler($apiKey, $http, $baseUrl);
    }

    protected function lastRequest(): RequestInterface
    {
        return $this->history[array_key_last($this->history)]['request'];
    }

    /** @return array<string, mixed> */
    protected function jsonBody(RequestInterface $request): array
    {
        return json_decode($this->rawBody($request), true, flags: JSON_THROW_ON_ERROR);
    }

    // Decoding to an array can't tell `{}` from `[]`.
    protected function rawBody(RequestInterface $request): string
    {
        return (string) $request->getBody();
    }

    /** @param array<mixed> $data */
    protected static function jsonResponse(array $data): Response
    {
        return self::rawJsonResponse(json_encode($data, JSON_THROW_ON_ERROR));
    }

    protected static function rawJsonResponse(string $json): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], $json);
    }

    /** @return array<string, mixed> */
    protected static function createdRunJson(): array
    {
        return ['id' => '0198f0e2-1111-7c1d-8f4b-2a6d5e7c9b10', 'thread' => '0198f0e2-2222-7c1d-8f4b-2a6d5e7c9b10'];
    }

    /** @return array<string, mixed> */
    protected static function promptRunJson(): array
    {
        return [
            'id' => '0198f0e2-1111-7c1d-8f4b-2a6d5e7c9b10',
            'status' => 'completed',
            'createdAt' => '2026-06-23T12:00:00.123456+00:00',
            'finishedAt' => '2026-06-23T12:00:03.654321+00:00',
            'output' => 'Hello there!',
            'error' => null,
            'tokenUsage' => self::tokenUsageJson(),
            'cost' => self::costJson(),
            'emitted' => [],
            'transcript' => [['type' => 'text', 'content' => 'Hello there!', 'citations' => []]],
        ];
    }

    /** @return array<string, mixed> */
    protected static function workflowRunJson(): array
    {
        return [
            'id' => '0198f0e2-3333-7c1d-8f4b-2a6d5e7c9b10',
            'status' => 'completed',
            'createdAt' => '2026-06-23T12:00:00.123456+00:00',
            'finishedAt' => '2026-06-23T12:00:09.000001+00:00',
            'outputs' => ['answer' => '42'],
            'errors' => [],
            'tokenUsage' => self::tokenUsageJson(),
            'cost' => self::costJson(),
        ];
    }

    /** @return array<string, mixed> */
    protected static function promptRevisionJson(): array
    {
        return [
            'id' => '0198f0e2-4444-7c1d-8f4b-2a6d5e7c9b10',
            'promptId' => '0198f0e2-5555-7c1d-8f4b-2a6d5e7c9b10',
            'memory' => 'stateless',
            'provider' => 'openai',
            'model' => 'gpt-6-sol',
            'modelParams' => ['temperature' => 0.7, 'serviceTier' => 'auto'],
            'responseFormat' => ['type' => 'text'],
            'systemInstruction' => 'Answer briefly.',
            'messages' => [['role' => 'user', 'content' => 'Say hello about {{topic}}.']],
            'tools' => [],
        ];
    }

    /** @return array<string, mixed> */
    protected static function knowledgeBaseJson(): array
    {
        return [
            'id' => '0198f0e2-6666-7c1d-8f4b-2a6d5e7c9b10',
            'status' => 'ready',
            'documentCount' => 1,
            'chunkCount' => 12,
            'documents' => [[
                'id' => '0198f0e2-7777-7c1d-8f4b-2a6d5e7c9b10',
                'status' => 'ready',
                'fileName' => 'handbook.pdf',
                'bytes' => 52_431,
                'mimeType' => 'application/pdf',
            ]],
        ];
    }

    /** @return array<string, mixed> */
    protected static function knowledgeDocumentJson(string $fileName): array
    {
        return [
            'id' => '0198f0e2-7777-7c1d-8f4b-2a6d5e7c9b10',
            'status' => 'pending',
            'fileName' => $fileName,
            'bytes' => 11,
            'chunkCount' => 0,
        ];
    }

    /** @return array<string, mixed> */
    private static function tokenUsageJson(): array
    {
        return ['input' => 120, 'inputCached' => 0, 'output' => 34, 'reasoning' => 0, 'total' => 154];
    }

    /** @return array<string, mixed> */
    private static function costJson(): array
    {
        $cost = [
            'input' => 0.00012,
            'cachedInput' => 0.0,
            'cacheWrite' => 0.0,
            'output' => 0.00034,
            'webSearch' => 0.0,
            'total' => 0.00046,
        ];

        return ['success' => $cost, 'retries' => $cost, 'total' => 0.00092];
    }
}
