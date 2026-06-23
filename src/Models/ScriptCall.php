<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Call custom Python or JavaScript function.
*/
class ScriptCall implements AdditionalDataHolder, Parsable 
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
    */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $code The script that this tool executes.
    */
    private ?string $code = null;
    
    /**
     * @var string|null $description The tool’s description.
    */
    private ?string $description = null;
    
    /**
     * @var bool|null $failFast Whether to stop processing if a tool call fails.
    */
    private ?bool $failFast = null;
    
    /**
     * @var ScriptCall_language|null $language The language of the script to execute.
    */
    private ?ScriptCall_language $language = null;
    
    /**
     * @var string|null $name The tool’s name.
    */
    private ?string $name = null;
    
    /**
     * @var ScriptCall_type|null $type The type property
    */
    private ?ScriptCall_type $type = null;
    
    /**
     * Instantiates a new ScriptCall and sets the default values.
    */
    public function __construct() {
        $this->setAdditionalData([]);
        $this->setFailFast(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ScriptCall
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ScriptCall {
        return new ScriptCall();
    }

    /**
     * Gets the AdditionalData property value. Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     * @return array<string, mixed>|null
    */
    public function getAdditionalData(): ?array {
        return $this->additionalData;
    }

    /**
     * Gets the code property value. The script that this tool executes.
     * @return string|null
    */
    public function getCode(): ?string {
        return $this->code;
    }

    /**
     * Gets the description property value. The tool’s description.
     * @return string|null
    */
    public function getDescription(): ?string {
        return $this->description;
    }

    /**
     * Gets the failFast property value. Whether to stop processing if a tool call fails.
     * @return bool|null
    */
    public function getFailFast(): ?bool {
        return $this->failFast;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        $o = $this;
        return  [
            'code' => fn(ParseNode $n) => $o->setCode($n->getStringValue()),
            'description' => fn(ParseNode $n) => $o->setDescription($n->getStringValue()),
            'failFast' => fn(ParseNode $n) => $o->setFailFast($n->getBooleanValue()),
            'language' => fn(ParseNode $n) => $o->setLanguage($n->getEnumValue(ScriptCall_language::class)),
            'name' => fn(ParseNode $n) => $o->setName($n->getStringValue()),
            'type' => fn(ParseNode $n) => $o->setType($n->getEnumValue(ScriptCall_type::class)),
        ];
    }

    /**
     * Gets the language property value. The language of the script to execute.
     * @return ScriptCall_language|null
    */
    public function getLanguage(): ?ScriptCall_language {
        return $this->language;
    }

    /**
     * Gets the name property value. The tool’s name.
     * @return string|null
    */
    public function getName(): ?string {
        return $this->name;
    }

    /**
     * Gets the type property value. The type property
     * @return ScriptCall_type|null
    */
    public function getType(): ?ScriptCall_type {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        $writer->writeStringValue('code', $this->getCode());
        $writer->writeStringValue('description', $this->getDescription());
        $writer->writeBooleanValue('failFast', $this->getFailFast());
        $writer->writeEnumValue('language', $this->getLanguage());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeEnumValue('type', $this->getType());
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
     * Sets the code property value. The script that this tool executes.
     * @param string|null $value Value to set for the code property.
    */
    public function setCode(?string $value): void {
        $this->code = $value;
    }

    /**
     * Sets the description property value. The tool’s description.
     * @param string|null $value Value to set for the description property.
    */
    public function setDescription(?string $value): void {
        $this->description = $value;
    }

    /**
     * Sets the failFast property value. Whether to stop processing if a tool call fails.
     * @param bool|null $value Value to set for the failFast property.
    */
    public function setFailFast(?bool $value): void {
        $this->failFast = $value;
    }

    /**
     * Sets the language property value. The language of the script to execute.
     * @param ScriptCall_language|null $value Value to set for the language property.
    */
    public function setLanguage(?ScriptCall_language $value): void {
        $this->language = $value;
    }

    /**
     * Sets the name property value. The tool’s name.
     * @param string|null $value Value to set for the name property.
    */
    public function setName(?string $value): void {
        $this->name = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param ScriptCall_type|null $value Value to set for the type property.
    */
    public function setType(?ScriptCall_type $value): void {
        $this->type = $value;
    }

}
