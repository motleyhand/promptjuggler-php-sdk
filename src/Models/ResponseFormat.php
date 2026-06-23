<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes JsonObjectFormat, JsonSchemaFormat, TextFormat
*/
class ResponseFormat implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var JsonObjectFormat|null $jsonObjectFormat Composed type representation for type JsonObjectFormat
    */
    private ?JsonObjectFormat $jsonObjectFormat = null;
    
    /**
     * @var JsonSchemaFormat|null $jsonSchemaFormat Composed type representation for type JsonSchemaFormat
    */
    private ?JsonSchemaFormat $jsonSchemaFormat = null;
    
    /**
     * @var TextFormat|null $textFormat Composed type representation for type TextFormat
    */
    private ?TextFormat $textFormat = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ResponseFormat
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ResponseFormat {
        $result = new ResponseFormat();
        $mappingValueNode = $parseNode->getChildNode("type");
        if ($mappingValueNode !== null) {
            $mappingValue = $mappingValueNode->getStringValue();
            if ('json_object' === $mappingValue) {
                $result->setJsonObjectFormat(new JsonObjectFormat());
            } else if ('json_schema' === $mappingValue) {
                $result->setJsonSchemaFormat(new JsonSchemaFormat());
            } else if ('text' === $mappingValue) {
                $result->setTextFormat(new TextFormat());
            }
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getJsonObjectFormat() !== null) {
            return $this->getJsonObjectFormat()->getFieldDeserializers();
        } else if ($this->getJsonSchemaFormat() !== null) {
            return $this->getJsonSchemaFormat()->getFieldDeserializers();
        } else if ($this->getTextFormat() !== null) {
            return $this->getTextFormat()->getFieldDeserializers();
        }
        return [];
    }

    /**
     * Gets the JsonObjectFormat property value. Composed type representation for type JsonObjectFormat
     * @return JsonObjectFormat|null
    */
    public function getJsonObjectFormat(): ?JsonObjectFormat {
        return $this->jsonObjectFormat;
    }

    /**
     * Gets the JsonSchemaFormat property value. Composed type representation for type JsonSchemaFormat
     * @return JsonSchemaFormat|null
    */
    public function getJsonSchemaFormat(): ?JsonSchemaFormat {
        return $this->jsonSchemaFormat;
    }

    /**
     * Gets the TextFormat property value. Composed type representation for type TextFormat
     * @return TextFormat|null
    */
    public function getTextFormat(): ?TextFormat {
        return $this->textFormat;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getJsonObjectFormat() !== null) {
            $writer->writeObjectValue(null, $this->getJsonObjectFormat());
        } else if ($this->getJsonSchemaFormat() !== null) {
            $writer->writeObjectValue(null, $this->getJsonSchemaFormat());
        } else if ($this->getTextFormat() !== null) {
            $writer->writeObjectValue(null, $this->getTextFormat());
        }
    }

    /**
     * Sets the JsonObjectFormat property value. Composed type representation for type JsonObjectFormat
     * @param JsonObjectFormat|null $value Value to set for the JsonObjectFormat property.
    */
    public function setJsonObjectFormat(?JsonObjectFormat $value): void {
        $this->jsonObjectFormat = $value;
    }

    /**
     * Sets the JsonSchemaFormat property value. Composed type representation for type JsonSchemaFormat
     * @param JsonSchemaFormat|null $value Value to set for the JsonSchemaFormat property.
    */
    public function setJsonSchemaFormat(?JsonSchemaFormat $value): void {
        $this->jsonSchemaFormat = $value;
    }

    /**
     * Sets the TextFormat property value. Composed type representation for type TextFormat
     * @param TextFormat|null $value Value to set for the TextFormat property.
    */
    public function setTextFormat(?TextFormat $value): void {
        $this->textFormat = $value;
    }

}
