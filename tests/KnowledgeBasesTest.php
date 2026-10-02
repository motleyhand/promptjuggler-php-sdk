<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use InvalidArgumentException;
use PromptJuggler\Client\Models\KnowledgeBaseStatus;
use PromptJuggler\Client\Models\KnowledgeDocumentResponse;
use PromptJuggler\Client\Models\KnowledgeDocumentStatus;

final class KnowledgeBasesTest extends SdkTestCase
{
    public function testGetKnowledgeBaseIssuesAuthorizedGetRequest(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse(self::knowledgeBaseJson())]);

        $knowledgeBase = $pj->getKnowledgeBase('docs');

        $request = $this->lastRequest();
        self::assertSame('GET', $request->getMethod());
        self::assertSame('/api/v1/knowledge-bases/docs', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
        self::assertSame(KnowledgeBaseStatus::Ready, $knowledgeBase->status);
        self::assertSame('handbook.pdf', $knowledgeBase->documents[0]->fileName);
    }

    public function testUploadDocumentsPostsMultipartPartsNamedFilesWithFilenames(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([
            self::knowledgeDocumentJson('report.pdf'),
            self::knowledgeDocumentJson('2024'),
        ])]);

        $documents = $pj->uploadDocuments('docs', ['report.pdf' => 'PDF-CONTENT', '2024' => 'numbered']);

        $request = $this->lastRequest();
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/knowledge-bases/docs/documents', $request->getUri()->getPath());
        self::assertSame('Bearer sk-test', $request->getHeaderLine('Authorization'));
        self::assertStringStartsWith('multipart/form-data; boundary=', $request->getHeaderLine('Content-Type'));

        $body = $this->rawBody($request);
        self::assertStringContainsString('name="files[0]"; filename="report.pdf"', $body);
        self::assertStringContainsString('PDF-CONTENT', $body);
        self::assertStringContainsString('name="files[1]"; filename="2024"', $body);
        self::assertStringContainsString('numbered', $body);

        self::assertCount(2, $documents);
        self::assertContainsOnlyInstancesOf(KnowledgeDocumentResponse::class, $documents);
        self::assertSame(['report.pdf', '2024'], [$documents[0]->fileName, $documents[1]->fileName]);
        self::assertSame(KnowledgeDocumentStatus::Pending, $documents[0]->status);
    }

    public function testUploadDocumentsSendsAWellFormedMultipartBody(): void
    {
        $pj = $this->client('sk-test', [self::jsonResponse([self::knowledgeDocumentJson('a.txt')])]);

        $pj->uploadDocuments('docs', ['a"b\c.txt' => 'hello']);

        $request = $this->lastRequest();
        self::assertSame(
            1,
            preg_match('/^multipart\/form-data; boundary=(\S+)$/', $request->getHeaderLine('Content-Type'), $match),
        );
        $boundary = $match[1];
        // PHP's multipart parser unescapes `\"` (and, like a browser, keeps only what follows the last `\`).
        self::assertSame(
            "--{$boundary}\r\n"
            . "Content-Disposition: form-data; name=\"files[0]\"; filename=\"a\\\"b\\\\c.txt\"\r\n"
            . "Content-Type: application/octet-stream\r\n"
            . "\r\n"
            . "hello\r\n"
            . "--{$boundary}--\r\n",
            $this->rawBody($request),
        );
    }

    public function testUploadDocumentsRejectsAFilenameWithALineBreakBeforeSending(): void
    {
        $pj = $this->client('sk-test', []);

        try {
            $pj->uploadDocuments('docs', ["a\r\nb.txt" => 'hello']);
            self::fail('Expected an InvalidArgumentException.');
        } catch (InvalidArgumentException $e) {
            self::assertSame("A filename can't contain a line break: \"a\r\nb.txt\".", $e->getMessage());
        }
        self::assertSame([], $this->history);
    }
}
