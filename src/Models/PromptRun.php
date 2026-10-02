<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use DateTimeImmutable;

/**
 * Prompt run status and result.
 */
final readonly class PromptRun
{
    /**
     * @param string $id Prompt run ID.
     * @param RunStatus|UnknownEnumValue $status Current run status.
     * @param DateTimeImmutable $createdAt Timestamp when the run was created.
     * @param list<EmittedItem> $emitted Payloads produced by emit tools during this run, in call order. Empty until the run completes.
     * @param list<TranscriptItem> $transcript The run as a renderable sequence: assistant text, the tools it used, and emit payloads in position. Empty until the run completes. `output` remains the flat text for callers that only need the answer.
     * @param DateTimeImmutable|null $finishedAt Timestamp when the run finished. Null while the run is pending.
     * @param string|null $output LLM output text produced so far; read `status` for completeness. Null when the run failed, or when the model returned no text — e.g. a turn that was only tool calls or only reasoning.
     * @param string|null $error Error message from the latest failed attempt, kept even once a retry recovers — so a pending or completed run can carry one. Read `status` for the outcome.
     * @param TokenUsage|null $tokenUsage Token usage accumulated over successful turns — a run that failed later still reports the earlier ones. Null until the first turn succeeds.
     * @param RunCost|null $cost Cost breakdown for the run. Null while pending, or when no published rate covers the run.
     */
    public function __construct(
        public string $id,
        public RunStatus|UnknownEnumValue $status,
        public DateTimeImmutable $createdAt,
        public array $emitted,
        public array $transcript,
        public ?DateTimeImmutable $finishedAt = null,
        public ?string $output = null,
        public ?string $error = null,
        public ?TokenUsage $tokenUsage = null,
        public ?RunCost $cost = null,
    ) {
    }
}
