<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use UnexpectedValueException;

/**
 * Prompt run status and result.
 */
class PromptRun implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var PromptRun_cost|null $cost Cost breakdown for the run. Null while pending, or when no published rate covers the run.
     */
    private ?PromptRun_cost $cost = null;
    
    /**
     * @var DateTime|null $createdAt Timestamp when the run was created.
     */
    private ?DateTime $createdAt = null;
    
    /**
     * @var array<EmittedItem>|null $emitted Payloads produced by emit tools during this run, in call order. Empty until the run completes.
     */
    private ?array $emitted = null;
    
    /**
     * @var string|null $error Error message from the latest failed attempt, kept even once a retry recovers — so a pending or completed run can carry one. Read `status` for the outcome.
     */
    private ?string $error = null;
    
    /**
     * @var DateTime|null $finishedAt Timestamp when the run finished. Null while the run is pending.
     */
    private ?DateTime $finishedAt = null;
    
    /**
     * @var string|null $id Prompt run ID.
     */
    private ?string $id = null;
    
    /**
     * @var string|null $output LLM output text produced so far; read `status` for completeness. Null when the run failed, or when the model returned no text — e.g. a turn that was only tool calls or only reasoning.
     */
    private ?string $output = null;
    
    /**
     * @var RunStatus|null $status Current run status.
     */
    private ?RunStatus $status = null;
    
    /**
     * @var PromptRun_tokenUsage|null $tokenUsage Token usage accumulated over successful turns — a run that failed later still reports the earlier ones. Null until the first turn succeeds.
     */
    private ?PromptRun_tokenUsage $tokenUsage = null;
    
    /**
     * @var array<TranscriptItem>|null $transcript The run as a renderable sequence: assistant text, the tools it used, and emit payloads in position. Empty until the run completes. `output` remains the flat text for callers that only need the answer.
     */
    private ?array $transcript = null;
    
    /**
     * Instantiates a new PromptRun and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PromptRun
    {
        return new PromptRun();
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
     * Gets the cost property value. Cost breakdown for the run. Null while pending, or when no published rate covers the run.
     */
    public function getCost(): ?PromptRun_cost
    {
        return $this->cost;
    }

    /**
     * Gets the createdAt property value. Timestamp when the run was created.
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt ?? throw new UnexpectedValueException(
            'Required field PromptRun.createdAt is missing from the API response.',
        );
    }

    /**
     * Gets the emitted property value. Payloads produced by emit tools during this run, in call order. Empty until the run completes.
     * @return array<EmittedItem>
     */
    public function getEmitted(): array
    {
        return $this->emitted ?? throw new UnexpectedValueException(
            'Required field PromptRun.emitted is missing from the API response.',
        );
    }

    /**
     * Gets the error property value. Error message from the latest failed attempt, kept even once a retry recovers — so a pending or completed run can carry one. Read `status` for the outcome.
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'cost' => static fn (ParseNode $n) => $o->setCost(
                $n->getObjectValue([PromptRun_cost::class, 'createFromDiscriminatorValue']),
            ),
            'createdAt' => static fn (ParseNode $n) => $o->setCreatedAt($n->getDateTimeValue()),
            'emitted' => static fn (ParseNode $n) => $o->setEmitted(
                $n->getCollectionOfObjectValues([EmittedItem::class, 'createFromDiscriminatorValue']),
            ),
            'error' => static fn (ParseNode $n) => $o->setError($n->getStringValue()),
            'finishedAt' => static fn (ParseNode $n) => $o->setFinishedAt($n->getDateTimeValue()),
            'id' => static fn (ParseNode $n) => $o->setId($n->getStringValue()),
            'output' => static fn (ParseNode $n) => $o->setOutput($n->getStringValue()),
            'status' => static fn (ParseNode $n) => $o->setStatus($n->getEnumValue(RunStatus::class)),
            'tokenUsage' => static fn (ParseNode $n) => $o->setTokenUsage(
                $n->getObjectValue([PromptRun_tokenUsage::class, 'createFromDiscriminatorValue']),
            ),
            'transcript' => static fn (ParseNode $n) => $o->setTranscript(
                $n->getCollectionOfObjectValues([TranscriptItem::class, 'createFromDiscriminatorValue']),
            ),
        ];
    }

    /**
     * Gets the finishedAt property value. Timestamp when the run finished. Null while the run is pending.
     */
    public function getFinishedAt(): ?DateTime
    {
        return $this->finishedAt;
    }

    /**
     * Gets the id property value. Prompt run ID.
     */
    public function getId(): string
    {
        return $this->id ?? throw new UnexpectedValueException(
            'Required field PromptRun.id is missing from the API response.',
        );
    }

    /**
     * Gets the output property value. LLM output text produced so far; read `status` for completeness. Null when the run failed, or when the model returned no text — e.g. a turn that was only tool calls or only reasoning.
     */
    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * Gets the status property value. Current run status.
     */
    public function getStatus(): RunStatus
    {
        return $this->status ?? throw new UnexpectedValueException(
            'Required field PromptRun.status is missing from the API response.',
        );
    }

    /**
     * Gets the tokenUsage property value. Token usage accumulated over successful turns — a run that failed later still reports the earlier ones. Null until the first turn succeeds.
     */
    public function getTokenUsage(): ?PromptRun_tokenUsage
    {
        return $this->tokenUsage;
    }

    /**
     * Gets the transcript property value. The run as a renderable sequence: assistant text, the tools it used, and emit payloads in position. Empty until the run completes. `output` remains the flat text for callers that only need the answer.
     * @return array<TranscriptItem>
     */
    public function getTranscript(): array
    {
        return $this->transcript ?? throw new UnexpectedValueException(
            'Required field PromptRun.transcript is missing from the API response.',
        );
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeObjectValue('cost', $this->getCost());
        $writer->writeDateTimeValue('createdAt', $this->getCreatedAt());
        $writer->writeCollectionOfObjectValues('emitted', $this->getEmitted());
        $writer->writeStringValue('error', $this->getError());
        $writer->writeDateTimeValue('finishedAt', $this->getFinishedAt());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeStringValue('output', $this->getOutput());
        $writer->writeEnumValue('status', $this->getStatus());
        $writer->writeObjectValue('tokenUsage', $this->getTokenUsage());
        $writer->writeCollectionOfObjectValues('transcript', $this->getTranscript());
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
     * Sets the cost property value. Cost breakdown for the run. Null while pending, or when no published rate covers the run.
     * @param PromptRun_cost|null $value Value to set for the cost property.
     */
    public function setCost(?PromptRun_cost $value): void
    {
        $this->cost = $value;
    }

    /**
     * Sets the createdAt property value. Timestamp when the run was created.
     * @param DateTime|null $value Value to set for the createdAt property.
     */
    public function setCreatedAt(?DateTime $value): void
    {
        $this->createdAt = $value;
    }

    /**
     * Sets the emitted property value. Payloads produced by emit tools during this run, in call order. Empty until the run completes.
     * @param array<EmittedItem>|null $value Value to set for the emitted property.
     */
    public function setEmitted(?array $value): void
    {
        $this->emitted = $value;
    }

    /**
     * Sets the error property value. Error message from the latest failed attempt, kept even once a retry recovers — so a pending or completed run can carry one. Read `status` for the outcome.
     * @param string|null $value Value to set for the error property.
     */
    public function setError(?string $value): void
    {
        $this->error = $value;
    }

    /**
     * Sets the finishedAt property value. Timestamp when the run finished. Null while the run is pending.
     * @param DateTime|null $value Value to set for the finishedAt property.
     */
    public function setFinishedAt(?DateTime $value): void
    {
        $this->finishedAt = $value;
    }

    /**
     * Sets the id property value. Prompt run ID.
     * @param string|null $value Value to set for the id property.
     */
    public function setId(?string $value): void
    {
        $this->id = $value;
    }

    /**
     * Sets the output property value. LLM output text produced so far; read `status` for completeness. Null when the run failed, or when the model returned no text — e.g. a turn that was only tool calls or only reasoning.
     * @param string|null $value Value to set for the output property.
     */
    public function setOutput(?string $value): void
    {
        $this->output = $value;
    }

    /**
     * Sets the status property value. Current run status.
     * @param RunStatus|null $value Value to set for the status property.
     */
    public function setStatus(?RunStatus $value): void
    {
        $this->status = $value;
    }

    /**
     * Sets the tokenUsage property value. Token usage accumulated over successful turns — a run that failed later still reports the earlier ones. Null until the first turn succeeds.
     * @param PromptRun_tokenUsage|null $value Value to set for the tokenUsage property.
     */
    public function setTokenUsage(?PromptRun_tokenUsage $value): void
    {
        $this->tokenUsage = $value;
    }

    /**
     * Sets the transcript property value. The run as a renderable sequence: assistant text, the tools it used, and emit payloads in position. Empty until the run completes. `output` remains the flat text for callers that only need the answer.
     * @param array<TranscriptItem>|null $value Value to set for the transcript property.
     */
    public function setTranscript(?array $value): void
    {
        $this->transcript = $value;
    }
}
