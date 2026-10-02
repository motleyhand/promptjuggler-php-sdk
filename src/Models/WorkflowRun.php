<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use DateTimeImmutable;

/**
 * Workflow run status and results.
 */
final readonly class WorkflowRun
{
    /**
     * @param string $id Workflow run ID.
     * @param RunStatus|UnknownEnumValue $status Current run status.
     * @param DateTimeImmutable $createdAt Timestamp when the run was created.
     * @param array<string, string|null> $outputs Map of output node names to their values. Only completed output nodes appear, so a pending or failed run can return a partial map — read `status` for completeness.
     * @param list<string> $errors Node run messages: failures, warnings from nodes that completed anyway (e.g. a non-fail-fast assertion), and the latest error of a node still retrying. Non-empty does not mean the run failed — read `status`.
     * @param DateTimeImmutable|null $finishedAt Timestamp when the run finished. Null while the run is pending.
     * @param TokenUsage|null $tokenUsage Aggregated token usage across the workflow run. Null while pending.
     * @param RunCost|null $cost Aggregated cost breakdown across the workflow run. Null while pending, or when no published rate covers one of its runs.
     */
    public function __construct(
        public string $id,
        public RunStatus|UnknownEnumValue $status,
        public DateTimeImmutable $createdAt,
        public array $outputs,
        public array $errors,
        public ?DateTimeImmutable $finishedAt = null,
        public ?TokenUsage $tokenUsage = null,
        public ?RunCost $cost = null,
    ) {
    }
}
