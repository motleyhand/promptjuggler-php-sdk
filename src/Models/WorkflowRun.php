<?php

namespace PromptJuggler\Client\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Workflow run status and results.
*/
class WorkflowRun implements AdditionalDataHolder, Parsable 
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
     * @var array<string>|null $errors List of error messages from failed nodes. Empty array on success.
    */
    private ?array $errors = null;
    
    /**
     * @var DateTime|null $finishedAt Timestamp when the run finished. Null while the run is pending.
    */
    private ?DateTime $finishedAt = null;
    
    /**
     * @var string|null $id Workflow run ID.
    */
    private ?string $id = null;
    
    /**
     * @var WorkflowRun_outputs|null $outputs Map of output node names to their values. Empty object while pending.
    */
    private ?WorkflowRun_outputs $outputs = null;
    
    /**
     * @var RunStatus|null $status Current run status.
    */
    private ?RunStatus $status = null;
    
    /**
     * Instantiates a new WorkflowRun and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return WorkflowRun
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WorkflowRun {
        return new WorkflowRun();
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
     * Gets the errors property value. List of error messages from failed nodes. Empty array on success.
     * @return array<string>|null
    */
    public function getErrors(): ?array {
        return $this->errors;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'createdAt' => fn(ParseNode $n) => $o->setCreatedAt($n->getDateTimeValue()),
            'errors' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setErrors($val);
            },
            'finishedAt' => fn(ParseNode $n) => $o->setFinishedAt($n->getDateTimeValue()),
            'id' => fn(ParseNode $n) => $o->setId($n->getStringValue()),
            'outputs' => fn(ParseNode $n) => $o->setOutputs($n->getObjectValue([WorkflowRun_outputs::class, 'createFromDiscriminatorValue'])),
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
     * Gets the id property value. Workflow run ID.
     * @return string|null
    */
    public function getId(): ?string {
        return $this->id;
    }

    /**
     * Gets the outputs property value. Map of output node names to their values. Empty object while pending.
     * @return WorkflowRun_outputs|null
    */
    public function getOutputs(): ?WorkflowRun_outputs {
        return $this->outputs;
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
        $writer->writeCollectionOfPrimitiveValues('errors', $this->getErrors());
        $writer->writeDateTimeValue('finishedAt', $this->getFinishedAt());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeObjectValue('outputs', $this->getOutputs());
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
     * Sets the errors property value. List of error messages from failed nodes. Empty array on success.
     * @param array<string>|null $value Value to set for the errors property.
    */
    public function setErrors(?array $value): void {
        $this->errors = $value;
    }

    /**
     * Sets the finishedAt property value. Timestamp when the run finished. Null while the run is pending.
     * @param DateTime|null $value Value to set for the finishedAt property.
    */
    public function setFinishedAt(?DateTime $value): void {
        $this->finishedAt = $value;
    }

    /**
     * Sets the id property value. Workflow run ID.
     * @param string|null $value Value to set for the id property.
    */
    public function setId(?string $value): void {
        $this->id = $value;
    }

    /**
     * Sets the outputs property value. Map of output node names to their values. Empty object while pending.
     * @param WorkflowRun_outputs|null $value Value to set for the outputs property.
    */
    public function setOutputs(?WorkflowRun_outputs $value): void {
        $this->outputs = $value;
    }

    /**
     * Sets the status property value. Current run status.
     * @param RunStatus|null $value Value to set for the status property.
    */
    public function setStatus(?RunStatus $value): void {
        $this->status = $value;
    }

}
