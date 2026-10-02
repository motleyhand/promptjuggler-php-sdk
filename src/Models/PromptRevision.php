<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Prompt revision
 */
final readonly class PromptRevision
{
    /**
     * @param string $id Prompt revision ID.
     * @param string $promptId Prompt ID.
     * @param Memory|UnknownEnumValue $memory Memory mode.
     * @param Provider|UnknownEnumValue $provider AI provider.
     * @param Model|UnknownEnumValue $model AI model.
     * @param ModelParams $modelParams Model parameters.
     * @param ResponseFormat $responseFormat AI model response format.
     * @param list<ContentMessageResponse> $messages User and assistant messages.
     * @param list<Tool> $tools Available tools.
     * @param string|null $systemInstruction The system prompt.
     */
    public function __construct(
        public string $id,
        public string $promptId,
        public Memory|UnknownEnumValue $memory,
        public Provider|UnknownEnumValue $provider,
        public Model|UnknownEnumValue $model,
        public ModelParams $modelParams,
        public ResponseFormat $responseFormat,
        public array $messages,
        public array $tools,
        public ?string $systemInstruction = null,
    ) {
    }
}
