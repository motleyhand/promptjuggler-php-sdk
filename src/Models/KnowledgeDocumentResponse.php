<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Knowledge document
 */
final readonly class KnowledgeDocumentResponse
{
    /**
     * @param string $id Document ID
     * @param KnowledgeDocumentStatus|UnknownEnumValue $status Processing status
     * @param string $fileName Original file name
     * @param int $bytes File size in bytes
     * @param int $chunkCount Number of chunks extracted
     */
    public function __construct(
        public string $id,
        public KnowledgeDocumentStatus|UnknownEnumValue $status,
        public string $fileName,
        public int $bytes,
        public int $chunkCount,
    ) {
    }
}
