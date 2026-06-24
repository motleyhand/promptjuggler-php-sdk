<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use GuzzleHttp\Psr7\Response;

final class KnowledgeBasesTest extends SdkTestCase
{
    public function testGetKnowledgeBaseIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(['slug' => 'docs'])]);

        $pj->getKnowledgeBase('docs');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/knowledge-bases/docs', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
    }

    public function testUploadDocumentsPostsMultipartPartsNamedFilesWithFilenames(): void
    {
        $pj = $this->client('sk-test', [new Response(200, ['Content-Type' => 'application/json'], (string) json_encode([
            ['id' => 'doc_1', 'status' => 'pending', 'fileName' => 'report.pdf'],
        ]))]);

        $pj->uploadDocuments('docs', ['report.pdf' => 'PDF-CONTENT', 'notes.txt' => 'hello']);

        $request = $this->lastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/knowledge-bases/docs/documents', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
        self::assertStringStartsWith('multipart/form-data; boundary=', $request->getHeaderLine('Content-Type'));

        $body = (string) $request->getBody();
        self::assertStringContainsString('name="files[0]"; filename="report.pdf"', $body);
        self::assertStringContainsString('PDF-CONTENT', $body);
        self::assertStringContainsString('name="files[1]"; filename="notes.txt"', $body);
    }
}
