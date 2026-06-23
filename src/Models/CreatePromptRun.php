<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Request payload for creating a prompt run.
*/
class CreatePromptRun implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $channel Memory channel within the thread. Prompts on the same channel share conversational history; different channels are isolated.
    */
    private ?string $channel = null;
    
    /**
     * @var string|null $environment Environment that scopes which webhooks fire and which environment variables the run can access. Uses the default environment when omitted.
    */
    private ?string $environment = null;
    
    /**
     * @var CreatePromptRun_envVars|null $envVars Runtime environment variable overrides for this run. Keys must be UPPER_CASE. At most 50 entries, 64 KB total.
    */
    private ?CreatePromptRun_envVars $envVars = null;
    
    /**
     * @var CreatePromptRun_inputs|null $inputs Key-value map of input variable names to their values.
    */
    private ?CreatePromptRun_inputs $inputs = null;
    
    /**
     * @var CreatePromptRun_metadata|null $metadata Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings.
    */
    private ?CreatePromptRun_metadata $metadata = null;
    
    /**
     * @var CreatePromptRun_priority|null $priority Processing priority.
    */
    private ?CreatePromptRun_priority $priority = null;
    
    /**
     * @var string|null $thread Thread ID to continue a multi-turn conversation. Omit to start a new thread.
    */
    private ?string $thread = null;
    
    /**
     * Instantiates a new CreatePromptRun and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setChannel('default');
        $this->setPriority(new CreatePromptRun_priority('normal'));
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return CreatePromptRun
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): CreatePromptRun {
        return new CreatePromptRun();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the channel property value. Memory channel within the thread. Prompts on the same channel share conversational history; different channels are isolated.
     * @return string|null
    */
    public function getChannel(): ?string {
        return $this->channel;
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
     * @return CreatePromptRun_envVars|null
    */
    public function getEnvVars(): ?CreatePromptRun_envVars {
        return $this->envVars;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'channel' => fn(ParseNode $n) => $o->setChannel($n->getStringValue()),
            'environment' => fn(ParseNode $n) => $o->setEnvironment($n->getStringValue()),
            'envVars' => fn(ParseNode $n) => $o->setEnvVars($n->getObjectValue([CreatePromptRun_envVars::class, 'createFromDiscriminatorValue'])),
            'inputs' => fn(ParseNode $n) => $o->setInputs($n->getObjectValue([CreatePromptRun_inputs::class, 'createFromDiscriminatorValue'])),
            'metadata' => fn(ParseNode $n) => $o->setMetadata($n->getObjectValue([CreatePromptRun_metadata::class, 'createFromDiscriminatorValue'])),
            'priority' => fn(ParseNode $n) => $o->setPriority($n->getEnumValue(CreatePromptRun_priority::class)),
            'thread' => fn(ParseNode $n) => $o->setThread($n->getStringValue()),
        ];
    }

    /**
     * Gets the inputs property value. Key-value map of input variable names to their values.
     * @return CreatePromptRun_inputs|null
    */
    public function getInputs(): ?CreatePromptRun_inputs {
        return $this->inputs;
    }

    /**
     * Gets the metadata property value. Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings.
     * @return CreatePromptRun_metadata|null
    */
    public function getMetadata(): ?CreatePromptRun_metadata {
        return $this->metadata;
    }

    /**
     * Gets the priority property value. Processing priority.
     * @return CreatePromptRun_priority|null
    */
    public function getPriority(): ?CreatePromptRun_priority {
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
        $writer->writeStringValue('channel', $this->getChannel());
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
     * Sets the channel property value. Memory channel within the thread. Prompts on the same channel share conversational history; different channels are isolated.
     * @param string|null $value Value to set for the channel property.
    */
    public function setChannel(?string $value): void {
        $this->channel = $value;
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
     * @param CreatePromptRun_envVars|null $value Value to set for the envVars property.
    */
    public function setEnvVars(?CreatePromptRun_envVars $value): void {
        $this->envVars = $value;
    }

    /**
     * Sets the inputs property value. Key-value map of input variable names to their values.
     * @param CreatePromptRun_inputs|null $value Value to set for the inputs property.
    */
    public function setInputs(?CreatePromptRun_inputs $value): void {
        $this->inputs = $value;
    }

    /**
     * Sets the metadata property value. Arbitrary key-value metadata attached to the run. Values can be strings or arrays of strings.
     * @param CreatePromptRun_metadata|null $value Value to set for the metadata property.
    */
    public function setMetadata(?CreatePromptRun_metadata $value): void {
        $this->metadata = $value;
    }

    /**
     * Sets the priority property value. Processing priority.
     * @param CreatePromptRun_priority|null $value Value to set for the priority property.
    */
    public function setPriority(?CreatePromptRun_priority $value): void {
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
