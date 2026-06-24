<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * External HTTP call tool.
 */
class HttpCall implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $description The tool’s description.
     */
    private ?string $description = null;
    
    /**
     * @var bool|null $failFast Whether to stop processing if a tool call fails.
     */
    private ?bool $failFast = null;
    
    /**
     * @var array<HttpHeader>|null $headers The headers to send with the HTTP request. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     */
    private ?array $headers = null;
    
    /**
     * @var HttpCall_method|null $method The method property
     */
    private ?HttpCall_method $method = null;
    
    /**
     * @var string|null $name The tool’s name.
     */
    private ?string $name = null;
    
    /**
     * @var string|null $paramsSchema JSON schema of the parameters this tool expects.
     */
    private ?string $paramsSchema = null;
    
    /**
     * @var HttpCall_type|null $type The type property
     */
    private ?HttpCall_type $type = null;
    
    /**
     * @var string|null $url The URL to call. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     */
    private ?string $url = null;
    
    /**
     * Instantiates a new HttpCall and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
        $this->setFailFast(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): HttpCall
    {
        return new HttpCall();
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
     * Gets the description property value. The tool’s description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Gets the failFast property value. Whether to stop processing if a tool call fails.
     */
    public function getFailFast(): ?bool
    {
        return $this->failFast;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'description' => static fn (ParseNode $n) => $o->setDescription($n->getStringValue()),
            'failFast' => static fn (ParseNode $n) => $o->setFailFast($n->getBooleanValue()),
            'headers' => static fn (ParseNode $n) => $o->setHeaders(
                $n->getCollectionOfObjectValues([HttpHeader::class, 'createFromDiscriminatorValue']),
            ),
            'method' => static fn (ParseNode $n) => $o->setMethod($n->getEnumValue(HttpCall_method::class)),
            'name' => static fn (ParseNode $n) => $o->setName($n->getStringValue()),
            'paramsSchema' => static fn (ParseNode $n) => $o->setParamsSchema($n->getStringValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(HttpCall_type::class)),
            'url' => static fn (ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the headers property value. The headers to send with the HTTP request. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     * @return array<HttpHeader>|null
     */
    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    /**
     * Gets the method property value. The method property
     */
    public function getMethod(): ?HttpCall_method
    {
        return $this->method;
    }

    /**
     * Gets the name property value. The tool’s name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the paramsSchema property value. JSON schema of the parameters this tool expects.
     */
    public function getParamsSchema(): ?string
    {
        return $this->paramsSchema;
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?HttpCall_type
    {
        return $this->type;
    }

    /**
     * Gets the url property value. The URL to call. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeStringValue('description', $this->getDescription());
        $writer->writeBooleanValue('failFast', $this->getFailFast());
        $writer->writeCollectionOfObjectValues('headers', $this->getHeaders());
        $writer->writeEnumValue('method', $this->getMethod());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeStringValue('paramsSchema', $this->getParamsSchema());
        $writer->writeEnumValue('type', $this->getType());
        $writer->writeStringValue('url', $this->getUrl());
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
     * Sets the description property value. The tool’s description.
     * @param string|null $value Value to set for the description property.
     */
    public function setDescription(?string $value): void
    {
        $this->description = $value;
    }

    /**
     * Sets the failFast property value. Whether to stop processing if a tool call fails.
     * @param bool|null $value Value to set for the failFast property.
     */
    public function setFailFast(?bool $value): void
    {
        $this->failFast = $value;
    }

    /**
     * Sets the headers property value. The headers to send with the HTTP request. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     * @param array<HttpHeader>|null $value Value to set for the headers property.
     */
    public function setHeaders(?array $value): void
    {
        $this->headers = $value;
    }

    /**
     * Sets the method property value. The method property
     * @param HttpCall_method|null $value Value to set for the method property.
     */
    public function setMethod(?HttpCall_method $value): void
    {
        $this->method = $value;
    }

    /**
     * Sets the name property value. The tool’s name.
     * @param string|null $value Value to set for the name property.
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * Sets the paramsSchema property value. JSON schema of the parameters this tool expects.
     * @param string|null $value Value to set for the paramsSchema property.
     */
    public function setParamsSchema(?string $value): void
    {
        $this->paramsSchema = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param HttpCall_type|null $value Value to set for the type property.
     */
    public function setType(?HttpCall_type $value): void
    {
        $this->type = $value;
    }

    /**
     * Sets the url property value. The URL to call. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     * @param string|null $value Value to set for the url property.
     */
    public function setUrl(?string $value): void
    {
        $this->url = $value;
    }
}
