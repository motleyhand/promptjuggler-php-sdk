<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * RAG tool to search knowledge base.
 */
final readonly class KnowledgeSearch implements Tool
{
    /**
     * @param string $name The tool’s name.
     * @param bool $failFast Whether to stop processing if a tool call fails.
     * @param 'knowledge_search' $type
     * @param string|null $description The tool’s description.
     */
    public function __construct(
        public string $knowledgeBaseId,
        public string $name,
        public bool $failFast,
        public string $type,
        public ?string $description = null,
    ) {
    }
}
