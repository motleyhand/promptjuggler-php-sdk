<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PromptJuggler\Client\Exception\DecodeException;
use PromptJuggler\Client\Models\Citation;
use PromptJuggler\Client\Models\Emit;
use PromptJuggler\Client\Models\HttpCall;
use PromptJuggler\Client\Models\HttpCallMethod;
use PromptJuggler\Client\Models\HttpHeader;
use PromptJuggler\Client\Models\JsonObjectFormat;
use PromptJuggler\Client\Models\JsonSchemaFormat;
use PromptJuggler\Client\Models\KnowledgeSearch;
use PromptJuggler\Client\Models\Mcp;
use PromptJuggler\Client\Models\ModelCost;
use PromptJuggler\Client\Models\PromptCall;
use PromptJuggler\Client\Models\RunCost;
use PromptJuggler\Client\Models\ScriptCall;
use PromptJuggler\Client\Models\ScriptCallLanguage;
use PromptJuggler\Client\Models\ServiceTier;
use PromptJuggler\Client\Models\TextFormat;
use PromptJuggler\Client\Models\TokenUsage;
use PromptJuggler\Client\Models\ToolStatus;
use PromptJuggler\Client\Models\TranscriptData;
use PromptJuggler\Client\Models\TranscriptText;
use PromptJuggler\Client\Models\TranscriptTool;
use PromptJuggler\Client\Models\UnknownEnumValue;
use PromptJuggler\Client\Models\UnknownResponseFormat;
use PromptJuggler\Client\Models\UnknownTool;
use PromptJuggler\Client\Models\UnknownTranscriptItem;
use PromptJuggler\Client\Models\VersionRef;
use PromptJuggler\Client\Models\WebSearch;
use PromptJuggler\Client\Models\WorkflowCall;

final class DecodingTest extends SdkTestCase
{
    // Literal JSON: json_encode would write the zero costs as `0.0`, and the API sends `0`.
    public function testCostAndTokenUsageDecodeWithIntegerZeroesAsFloats(): void
    {
        $pj = $this->client('sk-test', [self::rawJsonResponse(<<<'JSON'
            {
                "id": "wfr_1",
                "status": "completed",
                "createdAt": "2026-06-23T12:00:00+00:00",
                "outputs": {},
                "errors": [],
                "tokenUsage": {
                    "input": 120, "inputCached": 20, "output": 34, "reasoning": 8, "total": 162,
                    "serviceTier": "flex", "inputCacheWrite": 5
                },
                "cost": {
                    "success": {
                        "input": 0.0012, "cachedInput": 0, "cacheWrite": 0, "output": 0.0034, "webSearch": 0,
                        "total": 0.0046
                    },
                    "retries": {"input": 0, "cachedInput": 0, "cacheWrite": 0, "output": 0, "webSearch": 0, "total": 0},
                    "total": 0.0046
                }
            }
            JSON)]);

        $run = $pj->getWorkflowRun('wfr_1');

        self::assertEquals(new TokenUsage(
            input: 120,
            inputCached: 20,
            output: 34,
            reasoning: 8,
            total: 162,
            serviceTier: ServiceTier::Flex,
            inputCacheWrite: 5,
        ), $run->tokenUsage);
        self::assertEquals(new RunCost(
            success: new ModelCost(
                input: 0.0012,
                cachedInput: 0.0,
                cacheWrite: 0.0,
                output: 0.0034,
                webSearch: 0.0,
                total: 0.0046,
            ),
            retries: new ModelCost(
                input: 0.0,
                cachedInput: 0.0,
                cacheWrite: 0.0,
                output: 0.0,
                webSearch: 0.0,
                total: 0.0,
            ),
            total: 0.0046,
        ), $run->cost);
        self::assertSame(0.0, $run->cost?->success->cachedInput);
    }

    public function testOutputsKeepNullValues(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(
            ['outputs' => ['answer' => '42', 'skipped' => null]] + self::workflowRunJson(),
        )]);

        self::assertSame(['answer' => '42', 'skipped' => null], $pj->getWorkflowRun('wfr_1')->outputs);
    }

    public function testToolUnionDecodesEveryVariant(): void
    {
        $unknown = ['type' => 'calculator', 'name' => 'calc', 'data' => ['precision' => 2]];
        $pj = $this->client('sk-test', [self::jsonResponse(['tools' => [
            ['type' => 'web_search', 'allowedDomains' => ['example.com']],
            [
                'type' => 'http',
                'name' => 'lookup',
                'description' => 'Looks things up.',
                'url' => 'https://example.com/api',
                'method' => 'POST',
                'headers' => [['key' => 'Authorization', 'value' => 'Bearer ${API_TOKEN}']],
                'paramsSchema' => '{"type":"object"}',
                'failFast' => true,
            ],
            ['type' => 'script', 'name' => 'calc', 'language' => 'python', 'code' => 'print(1)', 'failFast' => false],
            [
                'type' => 'mcp',
                'name' => 'docs',
                'url' => 'https://mcp.example.com',
                'authorizationToken' => '${MCP_TOKEN}',
                'allowedTools' => ['search'],
            ],
            ['type' => 'prompt', 'name' => 'summarise', 'versionRef' => [
                'definitionId' => 'prm_1',
                'idOrTag' => 3,
            ], 'failFast' => false],
            ['type' => 'workflow', 'name' => 'pipeline', 'versionRef' => [
                'definitionId' => 'wf_1',
                'idOrTag' => 'production',
            ], 'failFast' => false],
            ['type' => 'knowledge_search', 'name' => 'kb', 'knowledgeBaseId' => 'kb_1', 'failFast' => false],
            ['type' => 'emit', 'name' => 'report', 'paramsSchema' => '{"type":"object"}', 'failFast' => false],
            $unknown,
        ]] + self::promptRevisionJson())]);

        self::assertEquals([
            new WebSearch(type: 'web_search', allowedDomains: ['example.com']),
            new HttpCall(
                paramsSchema: '{"type":"object"}',
                url: 'https://example.com/api',
                method: HttpCallMethod::Post,
                name: 'lookup',
                failFast: true,
                type: 'http',
                headers: [new HttpHeader(key: 'Authorization', value: 'Bearer ${API_TOKEN}')],
                description: 'Looks things up.',
            ),
            new ScriptCall(
                language: ScriptCallLanguage::Python,
                code: 'print(1)',
                name: 'calc',
                failFast: false,
                type: 'script',
            ),
            new Mcp(
                name: 'docs',
                url: 'https://mcp.example.com',
                type: 'mcp',
                authorizationToken: '${MCP_TOKEN}',
                allowedTools: ['search'],
            ),
            new PromptCall(
                versionRef: new VersionRef(definitionId: 'prm_1', idOrTag: 3),
                name: 'summarise',
                failFast: false,
                type: 'prompt',
            ),
            new WorkflowCall(
                versionRef: new VersionRef(definitionId: 'wf_1', idOrTag: 'production'),
                name: 'pipeline',
                failFast: false,
                type: 'workflow',
            ),
            new KnowledgeSearch(knowledgeBaseId: 'kb_1', name: 'kb', failFast: false, type: 'knowledge_search'),
            new Emit(paramsSchema: '{"type":"object"}', name: 'report', failFast: false, type: 'emit'),
            new UnknownTool(type: 'calculator', data: $unknown),
        ], $pj->getPrompt('greeting', 1)->tools);
    }

    public function testWebSearchSentAsJustItsTypeDecodes(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(
            ['tools' => [['type' => 'web_search']]] + self::promptRevisionJson(),
        )]);

        self::assertEquals([new WebSearch(type: 'web_search')], $pj->getPrompt('greeting', 1)->tools);
    }

    /**
     * @param array<string, mixed> $json
     */
    #[DataProvider('responseFormats')]
    public function testResponseFormatUnionDecodesEveryVariant(array $json, object $expected): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['responseFormat' => $json] + self::promptRevisionJson())]);

        self::assertEquals($expected, $pj->getPrompt('greeting', 1)->responseFormat);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, object}>
     */
    public static function responseFormats(): iterable
    {
        yield 'text' => [['type' => 'text'], new TextFormat(type: 'text')];
        yield 'json_object' => [['type' => 'json_object'], new JsonObjectFormat(type: 'json_object')];
        yield 'json_schema' => [
            ['type' => 'json_schema', 'name' => 'answer', 'schema' => '{"type":"object"}', 'strict' => true],
            new JsonSchemaFormat(name: 'answer', schema: '{"type":"object"}', type: 'json_schema', strict: true),
        ];
        $xml = ['type' => 'xml', 'root' => 'answer'];
        yield 'unknown' => [$xml, new UnknownResponseFormat(type: 'xml', data: $xml)];
    }

    public function testTranscriptUnionDecodesEveryVariant(): void
    {
        $unknown = ['type' => 'image', 'url' => 'https://example.com/a.png'];
        $pj = $this->client('sk-test', [self::jsonResponse(['transcript' => [
            ['type' => 'text', 'content' => 'See the docs.', 'citations' => [[
                'title' => 'Docs',
                'url' => 'https://example.com/docs',
            ]]],
            ['type' => 'tool', 'name' => 'web_search', 'status' => 'ok', 'queries' => ['php enums'], 'citations' => []],
            ['type' => 'data', 'tool' => 'report', 'payload' => ['score' => 3]],
            $unknown,
        ]] + self::promptRunJson())]);

        self::assertEquals([
            new TranscriptText(
                content: 'See the docs.',
                citations: [new Citation(title: 'Docs', url: 'https://example.com/docs')],
                type: 'text',
            ),
            new TranscriptTool(
                name: 'web_search',
                status: ToolStatus::Ok,
                queries: ['php enums'],
                citations: [],
                type: 'tool',
            ),
            new TranscriptData(tool: 'report', payload: ['score' => 3], type: 'data'),
            new UnknownTranscriptItem(type: 'image', data: $unknown),
        ], $pj->getPromptRun('run_1')->transcript);
    }

    // The API adds fields and enum values without a major version, so a published client must
    // decode a response carrying ones it doesn't know.
    public function testFieldsAndEnumValuesNewerThanTheSdkDecode(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([
            'model' => 'gpt-9',
            'modelParams' => ['reasoningEffort' => 'ultra'],
            'responseFormat' => ['type' => 'text', 'addedLater' => 1],
            'tools' => [[
                'type' => 'http',
                'name' => 'lookup',
                'url' => 'https://example.com',
                'method' => 'QUERY',
                'paramsSchema' => '{}',
                'failFast' => false,
            ]],
            'addedLater' => true,
        ] + self::promptRevisionJson())]);

        $prompt = $pj->getPrompt('greeting', 'production');

        self::assertEquals(new UnknownEnumValue('gpt-9'), $prompt->model);
        self::assertEquals(new UnknownEnumValue('ultra'), $prompt->modelParams->reasoningEffort);
        self::assertEquals(new TextFormat(type: 'text'), $prompt->responseFormat);
        $tool = $prompt->tools[0];
        self::assertInstanceOf(HttpCall::class, $tool);
        self::assertEquals(new UnknownEnumValue('QUERY'), $tool->method);
    }

    public function testFreeFormPayloadKeepsStringsThatMatchAnEnumValue(): void
    {
        $payload = ['status' => 'pending', 'nested' => ['type' => 'http']];
        $pj = $this->client('sk-test', [self::jsonResponse(
            ['emitted' => [['tool' => 'report', 'payload' => $payload]]] + self::promptRunJson(),
        )]);

        self::assertSame($payload, $pj->getPromptRun('run_1')->emitted[0]->payload);
    }

    public function testDecodesDatesWithAndWithoutFractionalSeconds(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([
            'createdAt' => '2026-06-23T12:00:00.123456+00:00',
            'finishedAt' => '2026-06-23T14:00:03+02:00',
        ] + self::promptRunJson())]);

        $run = $pj->getPromptRun('run_1');

        self::assertSame('2026-06-23T12:00:00.123456+00:00', $run->createdAt->format('Y-m-d\TH:i:s.uP'));
        self::assertSame('2026-06-23T14:00:03.000000+02:00', $run->finishedAt?->format('Y-m-d\TH:i:s.uP'));
    }

    // Valinor's defaults would also read a number as a Unix timestamp.
    public function testRejectsANumberForADate(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['createdAt' => 1_782_216_000] + self::promptRunJson())]);

        $this->expectException(DecodeException::class);
        $this->expectExceptionMessage('createdAt: ');
        $pj->getPromptRun('run_1');
    }
}
