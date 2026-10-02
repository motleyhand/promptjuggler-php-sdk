<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

final readonly class CreateWorkflowRunResponse
{
    /**
     * @param string $id Workflow run ID
     * @param string $thread Thread ID for multi-turn runs
     */
    public function __construct(
        public string $id,
        public string $thread,
    ) {
    }
}
