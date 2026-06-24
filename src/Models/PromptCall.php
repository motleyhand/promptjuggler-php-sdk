<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Tool to invoke another prompt.
 */
class PromptCall implements AdditionalDataHolder, Parsable
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
     * @var string|null $name The tool’s name.
     */
    private ?string $name = null;
    
    /**
     * @var PromptCall_type|null $type The type property
     */
    private ?PromptCall_type $type = null;
    
    /**
     * @var VersionRef|null $versionRef Referencing the prompt revision either by id or version number or tag.
     */
    private ?VersionRef $versionRef = null;
    
    /**
     * Instantiates a new PromptCall and sets the default values.
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
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PromptCall
    {
        return new PromptCall();
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
            'name' => static fn (ParseNode $n) => $o->setName($n->getStringValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(PromptCall_type::class)),
            'versionRef' => static fn (ParseNode $n) => $o->setVersionRef(
                $n->getObjectValue([VersionRef::class, 'createFromDiscriminatorValue']),
            ),
        ];
    }

    /**
     * Gets the name property value. The tool’s name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?PromptCall_type
    {
        return $this->type;
    }

    /**
     * Gets the versionRef property value. Referencing the prompt revision either by id or version number or tag.
     */
    public function getVersionRef(): ?VersionRef
    {
        return $this->versionRef;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeStringValue('description', $this->getDescription());
        $writer->writeBooleanValue('failFast', $this->getFailFast());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeEnumValue('type', $this->getType());
        $writer->writeObjectValue('versionRef', $this->getVersionRef());
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
     * Sets the name property value. The tool’s name.
     * @param string|null $value Value to set for the name property.
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param PromptCall_type|null $value Value to set for the type property.
     */
    public function setType(?PromptCall_type $value): void
    {
        $this->type = $value;
    }

    /**
     * Sets the versionRef property value. Referencing the prompt revision either by id or version number or tag.
     * @param VersionRef|null $value Value to set for the versionRef property.
     */
    public function setVersionRef(?VersionRef $value): void
    {
        $this->versionRef = $value;
    }
}
