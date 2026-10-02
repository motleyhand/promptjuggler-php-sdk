<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * AI model parameters.
 */
final readonly class ModelParams
{
    /**
     * @param int|null $maxCompletionTokens Maximum completion tokens.
     * @param float|null $temperature Temperature.
     * @param float|null $topP Top P.
     * @param ModelParamsVerbosity|UnknownEnumValue|null $verbosity Verbosity.
     * @param ModelParamsReasoningEffort|UnknownEnumValue|null $reasoningEffort Reasoning effort.
     * @param bool|null $reasoningSummary Return reasoning summary.
     * @param ServiceTier|UnknownEnumValue|null $serviceTier Service tier.
     */
    public function __construct(
        public ?int $maxCompletionTokens = null,
        public ?float $temperature = null,
        public ?float $topP = null,
        public ModelParamsVerbosity|UnknownEnumValue|null $verbosity = null,
        public ModelParamsReasoningEffort|UnknownEnumValue|null $reasoningEffort = null,
        public ?bool $reasoningSummary = null,
        public ServiceTier|UnknownEnumValue|null $serviceTier = ServiceTier::Default,
    ) {
    }
}
