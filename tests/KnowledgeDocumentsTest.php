<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Psr7\Response;

final class KnowledgeDocumentsTest extends SdkTestCase
{
    public function testGetKnowledgeDocumentIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['id' => 'doc_1'])]);

        $pj->getKnowledgeDocument('doc_1');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/knowledge-documents/doc_1', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
    }

    public function testDeleteKnowledgeDocumentIssuesDeleteRequest(): void
    {
        $pj = $this->client('sk-test', [new Response(204)]);

        $pj->deleteKnowledgeDocument('doc_1');

        $request = $this->lastRequest();
        self::assertSame('DELETE', $request->getMethod());
        self::assertSame('/api/v1/knowledge-documents/doc_1', $request->getUri()->getPath());
    }
}
