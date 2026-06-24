<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Model parameters.
 */
class ModelParams implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var int|null $maxCompletionTokens Maximum completion tokens.
     */
    private ?int $maxCompletionTokens = null;
    
    /**
     * @var ModelParams_reasoningEffort|null $reasoningEffort Reasoning effort.
     */
    private ?ModelParams_reasoningEffort $reasoningEffort = null;
    
    /**
     * @var bool|null $reasoningSummary Return reasoning summary.
     */
    private ?bool $reasoningSummary = null;
    
    /**
     * @var ModelParams_serviceTier|null $serviceTier Service tier.
     */
    private ?ModelParams_serviceTier $serviceTier = null;
    
    /**
     * @var float|null $temperature Temperature.
     */
    private ?float $temperature = null;
    
    /**
     * @var float|null $topP Top P.
     */
    private ?float $topP = null;
    
    /**
     * @var ModelParams_verbosity|null $verbosity Verbosity.
     */
    private ?ModelParams_verbosity $verbosity = null;
    
    /**
     * Instantiates a new ModelParams and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ModelParams
    {
        return new ModelParams();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
     */
    public function getAdditionalData(): ?array
    {
        return $this->additionalData;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'maxCompletionTokens' => static fn (ParseNode $n) => $o->setMaxCompletionTokens($n->getIntegerValue()),
            'reasoningEffort' => static fn (ParseNode $n) => $o->setReasoningEffort(
                $n->getEnumValue(ModelParams_reasoningEffort::class),
            ),
            'reasoningSummary' => static fn (ParseNode $n) => $o->setReasoningSummary($n->getBooleanValue()),
            'serviceTier' => static fn (ParseNode $n) => $o->setServiceTier(
                $n->getObjectValue([ModelParams_serviceTier::class, 'createFromDiscriminatorValue']),
            ),
            'temperature' => static fn (ParseNode $n) => $o->setTemperature($n->getFloatValue()),
            'topP' => static fn (ParseNode $n) => $o->setTopP($n->getFloatValue()),
            'verbosity' => static fn (ParseNode $n) => $o->setVerbosity($n->getEnumValue(ModelParams_verbosity::class)),
        ];
    }

    /**
     * Gets the maxCompletionTokens property value. Maximum completion tokens.
     */
    public function getMaxCompletionTokens(): ?int
    {
        return $this->maxCompletionTokens;
    }

    /**
     * Gets the reasoningEffort property value. Reasoning effort.
     */
    public function getReasoningEffort(): ?ModelParams_reasoningEffort
    {
        return $this->reasoningEffort;
    }

    /**
     * Gets the reasoningSummary property value. Return reasoning summary.
     */
    public function getReasoningSummary(): ?bool
    {
        return $this->reasoningSummary;
    }

    /**
     * Gets the serviceTier property value. Service tier.
     */
    public function getServiceTier(): ?ModelParams_serviceTier
    {
        return $this->serviceTier;
    }

    /**
     * Gets the temperature property value. Temperature.
     */
    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    /**
     * Gets the topP property value. Top P.
     */
    public function getTopP(): ?float
    {
        return $this->topP;
    }

    /**
     * Gets the verbosity property value. Verbosity.
     */
    public function getVerbosity(): ?ModelParams_verbosity
    {
        return $this->verbosity;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeIntegerValue('maxCompletionTokens', $this->getMaxCompletionTokens());
        $writer->writeEnumValue('reasoningEffort', $this->getReasoningEffort());
        $writer->writeBooleanValue('reasoningSummary', $this->getReasoningSummary());
        $writer->writeObjectValue('serviceTier', $this->getServiceTier());
        $writer->writeFloatValue('temperature', $this->getTemperature());
        $writer->writeFloatValue('topP', $this->getTopP());
        $writer->writeEnumValue('verbosity', $this->getVerbosity());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
     */
    public function setAdditionalData(?array $value): void
    {
        $this->additionalData = $value;
    }

    /**
     * Sets the maxCompletionTokens property value. Maximum completion tokens.
     * @param int|null $value Value to set for the maxCompletionTokens property.
     */
    public function setMaxCompletionTokens(?int $value): void
    {
        $this->maxCompletionTokens = $value;
    }

    /**
     * Sets the reasoningEffort property value. Reasoning effort.
     * @param ModelParams_reasoningEffort|null $value Value to set for the reasoningEffort property.
     */
    public function setReasoningEffort(?ModelParams_reasoningEffort $value): void
    {
        $this->reasoningEffort = $value;
    }

    /**
     * Sets the reasoningSummary property value. Return reasoning summary.
     * @param bool|null $value Value to set for the reasoningSummary property.
     */
    public function setReasoningSummary(?bool $value): void
    {
        $this->reasoningSummary = $value;
    }

    /**
     * Sets the serviceTier property value. Service tier.
     * @param ModelParams_serviceTier|null $value Value to set for the serviceTier property.
     */
    public function setServiceTier(?ModelParams_serviceTier $value): void
    {
        $this->serviceTier = $value;
    }

    /**
     * Sets the temperature property value. Temperature.
     * @param float|null $value Value to set for the temperature property.
     */
    public function setTemperature(?float $value): void
    {
        $this->temperature = $value;
    }

    /**
     * Sets the topP property value. Top P.
     * @param float|null $value Value to set for the topP property.
     */
    public function setTopP(?float $value): void
    {
        $this->topP = $value;
    }

    /**
     * Sets the verbosity property value. Verbosity.
     * @param ModelParams_verbosity|null $value Value to set for the verbosity property.
     */
    public function setVerbosity(?ModelParams_verbosity $value): void
    {
        $this->verbosity = $value;
    }
}
