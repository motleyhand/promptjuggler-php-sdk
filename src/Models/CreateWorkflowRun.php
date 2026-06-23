<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Request payload for creating a workflow run.
*/
class CreateWorkflowRun implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $environment Environment that scopes which webhooks fire and which environment variables the run can access. Uses the default environment when omitted.
    */
    private ?string $environment = null;
    
    /**
     * @var CreateWorkflowRun_envVars|null $envVars Runtime environment variable overrides for this run. Keys must be UPPER_CASE. At most 50 entries, 64 KB total.
    */
    private ?CreateWorkflowRun_envVars $envVars = null;
    
    /**
     * @var CreateWorkflowRun_inputs|null $inputs Key-value map of input variable names to their values.
    */
    private ?CreateWorkflowRun_inputs $inputs = null;
    
    /**
     * @var CreateWorkflowRun_metadata|null $metadata Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings.
    */
    private ?CreateWorkflowRun_metadata $metadata = null;
    
    /**
     * @var CreateWorkflowRun_priority|null $priority Processing priority.
    */
    private ?CreateWorkflowRun_priority $priority = null;
    
    /**
     * @var string|null $thread Thread ID to continue a multi-turn conversation. Omit to start a new thread.
    */
    private ?string $thread = null;
    
    /**
     * Instantiates a new CreateWorkflowRun and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setPriority(new CreateWorkflowRun_priority('normal'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CreateWorkflowRun
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CreateWorkflowRun {
        return new CreateWorkflowRun();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the environment property value. Environment that scopes which webhooks fire and which environment variables the run can access. Uses the default environment when omitted.
     * @return string|null
    */
    public function getEnvironment(): ?string {
        return $this->environment;
    }

    /**
     * Gets the envVars property value. Runtime environment variable overrides for this run. Keys must be UPPER_CASE. At most 50 entries, 64 KB total.
     * @return CreateWorkflowRun_envVars|null
    */
    public function getEnvVars(): ?CreateWorkflowRun_envVars {
        return $this->envVars;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'environment' => fn(ParseNode $n) => $o->setEnvironment($n->getStringValue()),
            'envVars' => fn(ParseNode $n) => $o->setEnvVars($n->getObjectValue([CreateWorkflowRun_envVars::class, 'createFromDiscriminatorValue'])),
            'inputs' => fn(ParseNode $n) => $o->setInputs($n->getObjectValue([CreateWorkflowRun_inputs::class, 'createFromDiscriminatorValue'])),
            'metadata' => fn(ParseNode $n) => $o->setMetadata($n->getObjectValue([CreateWorkflowRun_metadata::class, 'createFromDiscriminatorValue'])),
            'priority' => fn(ParseNode $n) => $o->setPriority($n->getEnumValue(CreateWorkflowRun_priority::class)),
            'thread' => fn(ParseNode $n) => $o->setThread($n->getStringValue()),
        ];
    }

    /**
     * Gets the inputs property value. Key-value map of input variable names to their values.
     * @return CreateWorkflowRun_inputs|null
    */
    public function getInputs(): ?CreateWorkflowRun_inputs {
        return $this->inputs;
    }

    /**
     * Gets the metadata property value. Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings.
     * @return CreateWorkflowRun_metadata|null
    */
    public function getMetadata(): ?CreateWorkflowRun_metadata {
        return $this->metadata;
    }

    /**
     * Gets the priority property value. Processing priority.
     * @return CreateWorkflowRun_priority|null
    */
    public function getPriority(): ?CreateWorkflowRun_priority {
        return $this->priority;
    }

    /**
     * Gets the thread property value. Thread ID to continue a multi-turn conversation. Omit to start a new thread.
     * @return string|null
    */
    public function getThread(): ?string {
        return $this->thread;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('environment', $this->getEnvironment());
        $writer->writeObjectValue('envVars', $this->getEnvVars());
        $writer->writeObjectValue('inputs', $this->getInputs());
        $writer->writeObjectValue('metadata', $this->getMetadata());
        $writer->writeEnumValue('priority', $this->getPriority());
        $writer->writeStringValue('thread', $this->getThread());
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
     * Sets the environment property value. Environment that scopes which webhooks fire and which environment variables the run can access. Uses the default environment when omitted.
     * @param string|null $value Value to set for the environment property.
    */
    public function setEnvironment(?string $value): void {
        $this->environment = $value;
    }

    /**
     * Sets the envVars property value. Runtime environment variable overrides for this run. Keys must be UPPER_CASE. At most 50 entries, 64 KB total.
     * @param CreateWorkflowRun_envVars|null $value Value to set for the envVars property.
    */
    public function setEnvVars(?CreateWorkflowRun_envVars $value): void {
        $this->envVars = $value;
    }

    /**
     * Sets the inputs property value. Key-value map of input variable names to their values.
     * @param CreateWorkflowRun_inputs|null $value Value to set for the inputs property.
    */
    public function setInputs(?CreateWorkflowRun_inputs $value): void {
        $this->inputs = $value;
    }

    /**
     * Sets the metadata property value. Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings.
     * @param CreateWorkflowRun_metadata|null $value Value to set for the metadata property.
    */
    public function setMetadata(?CreateWorkflowRun_metadata $value): void {
        $this->metadata = $value;
    }

    /**
     * Sets the priority property value. Processing priority.
     * @param CreateWorkflowRun_priority|null $value Value to set for the priority property.
    */
    public function setPriority(?CreateWorkflowRun_priority $value): void {
        $this->priority = $value;
    }

    /**
     * Sets the thread property value. Thread ID to continue a multi-turn conversation. Omit to start a new thread.
     * @param string|null $value Value to set for the thread property.
    */
    public function setThread(?string $value): void {
        $this->thread = $value;
    }

}
