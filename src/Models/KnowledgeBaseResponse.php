<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Knowledge base with documents
 */
final readonly class KnowledgeBaseResponse
{
    /**
     * @param string $id Knowledge base ID
     * @param KnowledgeBaseStatus|UnknownEnumValue $status Processing status
     * @param int $documentCount Total number of documents
     * @param int $chunkCount Total number of chunks across all documents
     * @param list<KnowledgeDocumentSummary> $documents
     */
    public function __construct(
        public string $id,
        public KnowledgeBaseStatus|UnknownEnumValue $status,
        public int $documentCount,
        public int $chunkCount,
        public array $documents,
    ) {
    }
}
