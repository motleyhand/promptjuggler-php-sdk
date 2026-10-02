<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Mapping;

use CuyZ\Valinor\MapperBuilder;
use LogicException;
use PromptJuggler\Client\Models\Emit;
use PromptJuggler\Client\Models\HttpCall;
use PromptJuggler\Client\Models\HttpCallMethod;
use PromptJuggler\Client\Models\JsonObjectFormat;
use PromptJuggler\Client\Models\JsonSchemaFormat;
use PromptJuggler\Client\Models\KnowledgeBaseStatus;
use PromptJuggler\Client\Models\KnowledgeDocumentStatus;
use PromptJuggler\Client\Models\KnowledgeSearch;
use PromptJuggler\Client\Models\Mcp;
use PromptJuggler\Client\Models\Memory;
use PromptJuggler\Client\Models\Model;
use PromptJuggler\Client\Models\ModelParamsReasoningEffort;
use PromptJuggler\Client\Models\ModelParamsVerbosity;
use PromptJuggler\Client\Models\PromptCall;
use PromptJuggler\Client\Models\Provider;
use PromptJuggler\Client\Models\ResponseFormat;
use PromptJuggler\Client\Models\Role;
use PromptJuggler\Client\Models\RunStatus;
use PromptJuggler\Client\Models\ScriptCall;
use PromptJuggler\Client\Models\ScriptCallLanguage;
use PromptJuggler\Client\Models\ServiceTier;
use PromptJuggler\Client\Models\TextFormat;
use PromptJuggler\Client\Models\Tool;
use PromptJuggler\Client\Models\ToolStatus;
use PromptJuggler\Client\Models\TranscriptData;
use PromptJuggler\Client\Models\TranscriptItem;
use PromptJuggler\Client\Models\TranscriptText;
use PromptJuggler\Client\Models\TranscriptTool;
use PromptJuggler\Client\Models\UnknownEnumValue;
use PromptJuggler\Client\Models\UnknownResponseFormat;
use PromptJuggler\Client\Models\UnknownTool;
use PromptJuggler\Client\Models\UnknownTranscriptItem;
use PromptJuggler\Client\Models\WebSearch;
use PromptJuggler\Client\Models\WorkflowCall;

/**
 * Valinor can't choose between an enum and UnknownEnumValue for a known value without a converter per enum.
 * The converters are global: free-form properties carry #[RawJson] to stay out of their reach.
 *
 * @internal
 */
final class ModelMapping
{
    private const RESPONSE_FORMAT = [
        'text' => TextFormat::class,
        'json_object' => JsonObjectFormat::class,
        'json_schema' => JsonSchemaFormat::class,
    ];

    private const TOOL = [
        'web_search' => WebSearch::class,
        'http' => HttpCall::class,
        'script' => ScriptCall::class,
        'mcp' => Mcp::class,
        'prompt' => PromptCall::class,
        'workflow' => WorkflowCall::class,
        'knowledge_search' => KnowledgeSearch::class,
        'emit' => Emit::class,
    ];

    private const TRANSCRIPT_ITEM = [
        'text' => TranscriptText::class,
        'tool' => TranscriptTool::class,
        'data' => TranscriptData::class,
    ];

    public static function configure(MapperBuilder $builder): MapperBuilder
    {
        return $builder
            ->registerConverter(
                static fn (string $value): HttpCallMethod|UnknownEnumValue
                    => HttpCallMethod::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): KnowledgeBaseStatus|UnknownEnumValue
                    => KnowledgeBaseStatus::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): KnowledgeDocumentStatus|UnknownEnumValue
                    => KnowledgeDocumentStatus::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): Memory|UnknownEnumValue
                    => Memory::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): Model|UnknownEnumValue
                    => Model::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): ModelParamsReasoningEffort|UnknownEnumValue
                    => ModelParamsReasoningEffort::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): ModelParamsVerbosity|UnknownEnumValue
                    => ModelParamsVerbosity::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): Provider|UnknownEnumValue
                    => Provider::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): Role|UnknownEnumValue
                    => Role::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): RunStatus|UnknownEnumValue
                    => RunStatus::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): ScriptCallLanguage|UnknownEnumValue
                    => ScriptCallLanguage::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): ServiceTier|UnknownEnumValue
                    => ServiceTier::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(
                static fn (string $value): ToolStatus|UnknownEnumValue
                    => ToolStatus::tryFrom($value) ?? new UnknownEnumValue($value),
            )
            ->registerConverter(self::responseFormat(...))
            ->infer(ResponseFormat::class, self::responseFormatClass(...))
            ->registerConverter(self::tool(...))
            ->infer(Tool::class, self::toolClass(...))
            ->registerConverter(self::transcriptItem(...))
            ->infer(TranscriptItem::class, self::transcriptItemClass(...))
        ;
    }

    /**
     * @phpstan-pure
     * @param array<string, mixed> $value
     * @param pure-callable(array<string, mixed>): ResponseFormat $next
     */
    private static function responseFormat(array $value, callable $next): ResponseFormat
    {
        $tag = $value['type'] ?? null;

        return \is_string($tag) && !isset(self::RESPONSE_FORMAT[$tag])
            ? new UnknownResponseFormat($tag, $value)
            : $next($value);
    }

    /**
     * @phpstan-pure
     * @return class-string<TextFormat|JsonObjectFormat|JsonSchemaFormat>
     */
    private static function responseFormatClass(string $type): string
    {
        return self::RESPONSE_FORMAT[$type]
            ?? throw new LogicException("No ResponseFormat variant for type `{$type}`.");
    }

    /**
     * @phpstan-pure
     * @param array<string, mixed> $value
     * @param pure-callable(array<string, mixed>): Tool $next
     */
    private static function tool(array $value, callable $next): Tool
    {
        $tag = $value['type'] ?? null;

        return \is_string($tag) && !isset(self::TOOL[$tag])
            ? new UnknownTool($tag, $value)
            : $next($value);
    }

    /**
     * @phpstan-pure
     * @return class-string<WebSearch|HttpCall|ScriptCall|Mcp|PromptCall|WorkflowCall|KnowledgeSearch|Emit>
     */
    private static function toolClass(string $type): string
    {
        return self::TOOL[$type]
            ?? throw new LogicException("No Tool variant for type `{$type}`.");
    }

    /**
     * @phpstan-pure
     * @param array<string, mixed> $value
     * @param pure-callable(array<string, mixed>): TranscriptItem $next
     */
    private static function transcriptItem(array $value, callable $next): TranscriptItem
    {
        $tag = $value['type'] ?? null;

        return \is_string($tag) && !isset(self::TRANSCRIPT_ITEM[$tag])
            ? new UnknownTranscriptItem($tag, $value)
            : $next($value);
    }

    /**
     * @phpstan-pure
     * @return class-string<TranscriptText|TranscriptTool|TranscriptData>
     */
    private static function transcriptItemClass(string $type): string
    {
        return self::TRANSCRIPT_ITEM[$type]
            ?? throw new LogicException("No TranscriptItem variant for type `{$type}`.");
    }
}
