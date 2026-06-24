<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Built-in MCP server tool.
 */
class Mcp implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var array<string>|null $allowedTools Tool names the model may call. Empty or omitted allows all of the server’s tools.
     */
    private ?array $allowedTools = null;
    
    /**
     * @var string|null $authorizationToken Authorization token for the MCP server.
     */
    private ?string $authorizationToken = null;
    
    /**
     * @var string|null $name The MCP server tool’s name.
     */
    private ?string $name = null;
    
    /**
     * @var Mcp_type|null $type The type property
     */
    private ?Mcp_type $type = null;
    
    /**
     * @var string|null $url The URL of the MCP server.
     */
    private ?string $url = null;
    
    /**
     * Instantiates a new Mcp and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): Mcp
    {
        return new Mcp();
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
     * Gets the allowedTools property value. Tool names the model may call. Empty or omitted allows all of the server’s tools.
     * @return array<string>|null
     */
    public function getAllowedTools(): ?array
    {
        return $this->allowedTools;
    }

    /**
     * Gets the authorizationToken property value. Authorization token for the MCP server.
     */
    public function getAuthorizationToken(): ?string
    {
        return $this->authorizationToken;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'allowedTools' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (\is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setAllowedTools($val);
            },
            'authorizationToken' => static fn (ParseNode $n) => $o->setAuthorizationToken($n->getStringValue()),
            'name' => static fn (ParseNode $n) => $o->setName($n->getStringValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(Mcp_type::class)),
            'url' => static fn (ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the name property value. The MCP server tool’s name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?Mcp_type
    {
        return $this->type;
    }

    /**
     * Gets the url property value. The URL of the MCP server.
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
        $writer->writeCollectionOfPrimitiveValues('allowedTools', $this->getAllowedTools());
        $writer->writeStringValue('authorizationToken', $this->getAuthorizationToken());
        $writer->writeStringValue('name', $this->getName());
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
     * Sets the allowedTools property value. Tool names the model may call. Empty or omitted allows all of the server’s tools.
     * @param array<string>|null $value Value to set for the allowedTools property.
     */
    public function setAllowedTools(?array $value): void
    {
        $this->allowedTools = $value;
    }

    /**
     * Sets the authorizationToken property value. Authorization token for the MCP server.
     * @param string|null $value Value to set for the authorizationToken property.
     */
    public function setAuthorizationToken(?string $value): void
    {
        $this->authorizationToken = $value;
    }

    /**
     * Sets the name property value. The MCP server tool’s name.
     * @param string|null $value Value to set for the name property.
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param Mcp_type|null $value Value to set for the type property.
     */
    public function setType(?Mcp_type $value): void
    {
        $this->type = $value;
    }

    /**
     * Sets the url property value. The URL of the MCP server.
     * @param string|null $value Value to set for the url property.
     */
    public function setUrl(?string $value): void
    {
        $this->url = $value;
    }
}
