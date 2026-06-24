<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Prompt revision
 */
class PromptRevision implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $id Prompt revision ID.
     */
    private ?string $id = null;
    
    /**
     * @var Memory|null $memory Memory mode.
     */
    private ?Memory $memory = null;
    
    /**
     * @var array<ContentMessageResponse>|null $messages User and assistant messages.
     */
    private ?array $messages = null;
    
    /**
     * @var Model|null $model AI model.
     */
    private ?Model $model = null;
    
    /**
     * @var ModelParams|null $modelParams Model parameters.
     */
    private ?ModelParams $modelParams = null;
    
    /**
     * @var string|null $promptId Prompt ID.
     */
    private ?string $promptId = null;
    
    /**
     * @var Provider|null $provider AI provider.
     */
    private ?Provider $provider = null;
    
    /**
     * @var ResponseFormat|null $responseFormat AI model response format.
     */
    private ?ResponseFormat $responseFormat = null;
    
    /**
     * @var string|null $systemInstruction The system prompt.
     */
    private ?string $systemInstruction = null;
    
    /**
     * @var array<Tool>|null $tools Available tools.
     */
    private ?array $tools = null;
    
    /**
     * Instantiates a new PromptRevision and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PromptRevision
    {
        return new PromptRevision();
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
            'id' => static fn (ParseNode $n) => $o->setId($n->getStringValue()),
            'memory' => static fn (ParseNode $n) => $o->setMemory($n->getEnumValue(Memory::class)),
            'messages' => static fn (ParseNode $n) => $o->setMessages(
                $n->getCollectionOfObjectValues([ContentMessageResponse::class, 'createFromDiscriminatorValue']),
            ),
            'model' => static fn (ParseNode $n) => $o->setModel($n->getEnumValue(Model::class)),
            'modelParams' => static fn (ParseNode $n) => $o->setModelParams(
                $n->getObjectValue([ModelParams::class, 'createFromDiscriminatorValue']),
            ),
            'promptId' => static fn (ParseNode $n) => $o->setPromptId($n->getStringValue()),
            'provider' => static fn (ParseNode $n) => $o->setProvider($n->getEnumValue(Provider::class)),
            'responseFormat' => static fn (ParseNode $n) => $o->setResponseFormat(
                $n->getObjectValue([ResponseFormat::class, 'createFromDiscriminatorValue']),
            ),
            'systemInstruction' => static fn (ParseNode $n) => $o->setSystemInstruction($n->getStringValue()),
            'tools' => static fn (ParseNode $n) => $o->setTools(
                $n->getCollectionOfObjectValues([Tool::class, 'createFromDiscriminatorValue']),
            ),
        ];
    }

    /**
     * Gets the id property value. Prompt revision ID.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Gets the memory property value. Memory mode.
     */
    public function getMemory(): ?Memory
    {
        return $this->memory;
    }

    /**
     * Gets the messages property value. User and assistant messages.
     * @return array<ContentMessageResponse>|null
     */
    public function getMessages(): ?array
    {
        return $this->messages;
    }

    /**
     * Gets the model property value. AI model.
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * Gets the modelParams property value. Model parameters.
     */
    public function getModelParams(): ?ModelParams
    {
        return $this->modelParams;
    }

    /**
     * Gets the promptId property value. Prompt ID.
     */
    public function getPromptId(): ?string
    {
        return $this->promptId;
    }

    /**
     * Gets the provider property value. AI provider.
     */
    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    /**
     * Gets the responseFormat property value. AI model response format.
     */
    public function getResponseFormat(): ?ResponseFormat
    {
        return $this->responseFormat;
    }

    /**
     * Gets the systemInstruction property value. The system prompt.
     */
    public function getSystemInstruction(): ?string
    {
        return $this->systemInstruction;
    }

    /**
     * Gets the tools property value. Available tools.
     * @return array<Tool>|null
     */
    public function getTools(): ?array
    {
        return $this->tools;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeStringValue('id', $this->getId());
        $writer->writeEnumValue('memory', $this->getMemory());
        $writer->writeCollectionOfObjectValues('messages', $this->getMessages());
        $writer->writeEnumValue('model', $this->getModel());
        $writer->writeObjectValue('modelParams', $this->getModelParams());
        $writer->writeStringValue('promptId', $this->getPromptId());
        $writer->writeEnumValue('provider', $this->getProvider());
        $writer->writeObjectValue('responseFormat', $this->getResponseFormat());
        $writer->writeStringValue('systemInstruction', $this->getSystemInstruction());
        $writer->writeCollectionOfObjectValues('tools', $this->getTools());
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
     * Sets the id property value. Prompt revision ID.
     * @param string|null $value Value to set for the id property.
     */
    public function setId(?string $value): void
    {
        $this->id = $value;
    }

    /**
     * Sets the memory property value. Memory mode.
     * @param Memory|null $value Value to set for the memory property.
     */
    public function setMemory(?Memory $value): void
    {
        $this->memory = $value;
    }

    /**
     * Sets the messages property value. User and assistant messages.
     * @param array<ContentMessageResponse>|null $value Value to set for the messages property.
     */
    public function setMessages(?array $value): void
    {
        $this->messages = $value;
    }

    /**
     * Sets the model property value. AI model.
     * @param Model|null $value Value to set for the model property.
     */
    public function setModel(?Model $value): void
    {
        $this->model = $value;
    }

    /**
     * Sets the modelParams property value. Model parameters.
     * @param ModelParams|null $value Value to set for the modelParams property.
     */
    public function setModelParams(?ModelParams $value): void
    {
        $this->modelParams = $value;
    }

    /**
     * Sets the promptId property value. Prompt ID.
     * @param string|null $value Value to set for the promptId property.
     */
    public function setPromptId(?string $value): void
    {
        $this->promptId = $value;
    }

    /**
     * Sets the provider property value. AI provider.
     * @param Provider|null $value Value to set for the provider property.
     */
    public function setProvider(?Provider $value): void
    {
        $this->provider = $value;
    }

    /**
     * Sets the responseFormat property value. AI model response format.
     * @param ResponseFormat|null $value Value to set for the responseFormat property.
     */
    public function setResponseFormat(?ResponseFormat $value): void
    {
        $this->responseFormat = $value;
    }

    /**
     * Sets the systemInstruction property value. The system prompt.
     * @param string|null $value Value to set for the systemInstruction property.
     */
    public function setSystemInstruction(?string $value): void
    {
        $this->systemInstruction = $value;
    }

    /**
     * Sets the tools property value. Available tools.
     * @param array<Tool>|null $value Value to set for the tools property.
     */
    public function setTools(?array $value): void
    {
        $this->tools = $value;
    }
}
