<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * JSON schema response format.
 */
class JsonSchemaFormat implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $description Schema description.
     */
    private ?string $description = null;
    
    /**
     * @var string|null $name Schema name.
     */
    private ?string $name = null;
    
    /**
     * @var string|null $schema The JSON schema as string.
     */
    private ?string $schema = null;
    
    /**
     * @var bool|null $strict Whether the model should follow the schema strictly.
     */
    private ?bool $strict = null;
    
    /**
     * @var JsonSchemaFormat_type|null $type The type property
     */
    private ?JsonSchemaFormat_type $type = null;
    
    /**
     * Instantiates a new JsonSchemaFormat and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
        $this->setStrict(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): JsonSchemaFormat
    {
        return new JsonSchemaFormat();
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
     * Gets the description property value. Schema description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
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
            'name' => static fn (ParseNode $n) => $o->setName($n->getStringValue()),
            'schema' => static fn (ParseNode $n) => $o->setSchema($n->getStringValue()),
            'strict' => static fn (ParseNode $n) => $o->setStrict($n->getBooleanValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(JsonSchemaFormat_type::class)),
        ];
    }

    /**
     * Gets the name property value. Schema name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the schema property value. The JSON schema as string.
     */
    public function getSchema(): ?string
    {
        return $this->schema;
    }

    /**
     * Gets the strict property value. Whether the model should follow the schema strictly.
     */
    public function getStrict(): ?bool
    {
        return $this->strict;
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?JsonSchemaFormat_type
    {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeStringValue('description', $this->getDescription());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeStringValue('schema', $this->getSchema());
        $writer->writeBooleanValue('strict', $this->getStrict());
        $writer->writeEnumValue('type', $this->getType());
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
     * Sets the description property value. Schema description.
     * @param string|null $value Value to set for the description property.
     */
    public function setDescription(?string $value): void
    {
        $this->description = $value;
    }

    /**
     * Sets the name property value. Schema name.
     * @param string|null $value Value to set for the name property.
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * Sets the schema property value. The JSON schema as string.
     * @param string|null $value Value to set for the schema property.
     */
    public function setSchema(?string $value): void
    {
        $this->schema = $value;
    }

    /**
     * Sets the strict property value. Whether the model should follow the schema strictly.
     * @param bool|null $value Value to set for the strict property.
     */
    public function setStrict(?bool $value): void
    {
        $this->strict = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param JsonSchemaFormat_type|null $value Value to set for the type property.
     */
    public function setType(?JsonSchemaFormat_type $value): void
    {
        $this->type = $value;
    }
}
