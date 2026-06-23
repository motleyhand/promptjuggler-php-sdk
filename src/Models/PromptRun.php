<?php

namespace PromptJuggler\Client\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

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
     * @var DateTime|null $createdAt Timestamp when the run was created.
    */
    private ?DateTime $createdAt = null;
    
    /**
     * @var string|null $error Error message if the run failed. Null on success.
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
     * @var string|null $output LLM output text. Null while pending or when the run failed.
    */
    private ?string $output = null;
    
    /**
     * @var RunStatus|null $status Current run status.
    */
    private ?RunStatus $status = null;
    
    /**
     * Instantiates a new PromptRun and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return PromptRun
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PromptRun {
        return new PromptRun();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the createdAt property value. Timestamp when the run was created.
     * @return DateTime|null
    */
    public function getCreatedAt(): ?DateTime {
        return $this->createdAt;
    }

    /**
     * Gets the error property value. Error message if the run failed. Null on success.
     * @return string|null
    */
    public function getError(): ?string {
        return $this->error;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'createdAt' => fn(ParseNode $n) => $o->setCreatedAt($n->getDateTimeValue()),
            'error' => fn(ParseNode $n) => $o->setError($n->getStringValue()),
            'finishedAt' => fn(ParseNode $n) => $o->setFinishedAt($n->getDateTimeValue()),
            'id' => fn(ParseNode $n) => $o->setId($n->getStringValue()),
            'output' => fn(ParseNode $n) => $o->setOutput($n->getStringValue()),
            'status' => fn(ParseNode $n) => $o->setStatus($n->getEnumValue(RunStatus::class)),
        ];
    }

    /**
     * Gets the finishedAt property value. Timestamp when the run finished. Null while the run is pending.
     * @return DateTime|null
    */
    public function getFinishedAt(): ?DateTime {
        return $this->finishedAt;
    }

    /**
     * Gets the id property value. Prompt run ID.
     * @return string|null
    */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Gets the output property value. LLM output text. Null while pending or when the run failed.
     * @return string|null
    */
    public function getOutput(): ?string {
        return $this->output;
    }

    /**
     * Gets the status property value. Current run status.
     * @return RunStatus|null
    */
    public function getStatus(): ?RunStatus {
        return $this->status;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeDateTimeValue('createdAt', $this->getCreatedAt());
        $writer->writeStringValue('error', $this->getError());
        $writer->writeDateTimeValue('finishedAt', $this->getFinishedAt());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeStringValue('output', $this->getOutput());
        $writer->writeEnumValue('status', $this->getStatus());
        $writer->writeAdditionalData($this->getAdditionalData());
    }

    /**
     * Sets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @param array<string,mixed> $value Value to set for the AdditionalData property.
    */
    public function setAdditionalData(?array $value): void {
        $this->additionalData = $value;
    }

    /**
     * Sets the createdAt property value. Timestamp when the run was created.
     * @param DateTime|null $value Value to set for the createdAt property.
    */
    public function setCreatedAt(?DateTime $value): void {
        $this->createdAt = $value;
    }

    /**
     * Sets the error property value. Error message if the run failed. Null on success.
     * @param string|null $value Value to set for the error property.
    */
    public function setError(?string $value): void {
        $this->error = $value;
    }

    /**
     * Sets the finishedAt property value. Timestamp when the run finished. Null while the run is pending.
     * @param DateTime|null $value Value to set for the finishedAt property.
    */
    public function setFinishedAt(?DateTime $value): void {
        $this->finishedAt = $value;
    }

    /**
     * Sets the id property value. Prompt run ID.
     * @param string|null $value Value to set for the id property.
    */
    public function setId(?string $value): void {
        $this->id = $value;
    }

    /**
     * Sets the output property value. LLM output text. Null while pending or when the run failed.
     * @param string|null $value Value to set for the output property.
    */
    public function setOutput(?string $value): void {
        $this->output = $value;
    }

    /**
     * Sets the status property value. Current run status.
     * @param RunStatus|null $value Value to set for the status property.
    */
    public function setStatus(?RunStatus $value): void {
        $this->status = $value;
    }

}
