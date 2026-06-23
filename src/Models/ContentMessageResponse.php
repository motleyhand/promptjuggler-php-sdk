<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * User or assistant message.
*/
class ContentMessageResponse implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $content Message content.
    */
    private ?string $content = null;
    
    /**
     * @var Role|null $role Message direction / role.
    */
    private ?Role $role = null;
    
    /**
     * Instantiates a new ContentMessageResponse and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ContentMessageResponse
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ContentMessageResponse {
        return new ContentMessageResponse();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the content property value. Message content.
     * @return string|null
    */
    public function getContent(): ?string {
        return $this->content;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'content' => fn(ParseNode $n) => $o->setContent($n->getStringValue()),
            'role' => fn(ParseNode $n) => $o->setRole($n->getEnumValue(Role::class)),
        ];
    }

    /**
     * Gets the role property value. Message direction / role.
     * @return Role|null
    */
    public function getRole(): ?Role {
        return $this->role;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('content', $this->getContent());
        $writer->writeEnumValue('role', $this->getRole());
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
     * Sets the content property value. Message content.
     * @param string|null $value Value to set for the content property.
    */
    public function setContent(?string $value): void {
        $this->content = $value;
    }

    /**
     * Sets the role property value. Message direction / role.
     * @param Role|null $value Value to set for the role property.
    */
    public function setRole(?Role $value): void {
        $this->role = $value;
    }

}
