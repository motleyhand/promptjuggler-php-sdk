<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Referencing the prompt revision either by id or version number or tag.
 */
class VersionRef implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var VersionRef_idOrTag|null $idOrTag Revision ID or version number or tag.
     */
    private ?VersionRef_idOrTag $idOrTag = null;
    
    /**
     * @var string|null $parentId Definition – prompt or workflow – ID.
     */
    private ?string $parentId = null;
    
    /**
     * Instantiates a new VersionRef and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): VersionRef
    {
        return new VersionRef();
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
            'idOrTag' => static fn (ParseNode $n) => $o->setIdOrTag(
                $n->getObjectValue([VersionRef_idOrTag::class, 'createFromDiscriminatorValue']),
            ),
            'parentId' => static fn (ParseNode $n) => $o->setParentId($n->getStringValue()),
        ];
    }

    /**
     * Gets the idOrTag property value. Revision ID or version number or tag.
     */
    public function getIdOrTag(): ?VersionRef_idOrTag
    {
        return $this->idOrTag;
    }

    /**
     * Gets the parentId property value. Definition – prompt or workflow – ID.
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeObjectValue('idOrTag', $this->getIdOrTag());
        $writer->writeStringValue('parentId', $this->getParentId());
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
     * Sets the idOrTag property value. Revision ID or version number or tag.
     * @param VersionRef_idOrTag|null $value Value to set for the idOrTag property.
     */
    public function setIdOrTag(?VersionRef_idOrTag $value): void
    {
        $this->idOrTag = $value;
    }

    /**
     * Sets the parentId property value. Definition – prompt or workflow – ID.
     * @param string|null $value Value to set for the parentId property.
     */
    public function setParentId(?string $value): void
    {
        $this->parentId = $value;
    }
}
