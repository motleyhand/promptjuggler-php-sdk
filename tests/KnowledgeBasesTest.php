<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

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
}
