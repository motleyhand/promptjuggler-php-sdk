<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Knowledge document
 */
class KnowledgeDocumentResponse implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var int|null $bytes File size in bytes
     */
    private ?int $bytes = null;
    
    /**
     * @var int|null $chunkCount Number of chunks extracted
     */
    private ?int $chunkCount = null;
    
    /**
     * @var string|null $fileName Original file name
     */
    private ?string $fileName = null;
    
    /**
     * @var string|null $id Document ID
     */
    private ?string $id = null;
    
    /**
     * @var KnowledgeDocumentStatus|null $status Processing status
     */
    private ?KnowledgeDocumentStatus $status = null;
    
    /**
     * Instantiates a new KnowledgeDocumentResponse and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): KnowledgeDocumentResponse
    {
        return new KnowledgeDocumentResponse();
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
     * Gets the bytes property value. File size in bytes
     */
    public function getBytes(): ?int
    {
        return $this->bytes;
    }

    /**
     * Gets the chunkCount property value. Number of chunks extracted
     */
    public function getChunkCount(): ?int
    {
        return $this->chunkCount;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'bytes' => static fn (ParseNode $n) => $o->setBytes($n->getIntegerValue()),
            'chunkCount' => static fn (ParseNode $n) => $o->setChunkCount($n->getIntegerValue()),
            'fileName' => static fn (ParseNode $n) => $o->setFileName($n->getStringValue()),
            'id' => static fn (ParseNode $n) => $o->setId($n->getStringValue()),
            'status' => static fn (ParseNode $n) => $o->setStatus($n->getEnumValue(KnowledgeDocumentStatus::class)),
        ];
    }

    /**
     * Gets the fileName property value. Original file name
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Gets the id property value. Document ID
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Gets the status property value. Processing status
     */
    public function getStatus(): ?KnowledgeDocumentStatus
    {
        return $this->status;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeIntegerValue('bytes', $this->getBytes());
        $writer->writeIntegerValue('chunkCount', $this->getChunkCount());
        $writer->writeStringValue('fileName', $this->getFileName());
        $writer->writeStringValue('id', $this->getId());
        $writer->writeEnumValue('status', $this->getStatus());
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
     * Sets the bytes property value. File size in bytes
     * @param int|null $value Value to set for the bytes property.
     */
    public function setBytes(?int $value): void
    {
        $this->bytes = $value;
    }

    /**
     * Sets the chunkCount property value. Number of chunks extracted
     * @param int|null $value Value to set for the chunkCount property.
     */
    public function setChunkCount(?int $value): void
    {
        $this->chunkCount = $value;
    }

    /**
     * Sets the fileName property value. Original file name
     * @param string|null $value Value to set for the fileName property.
     */
    public function setFileName(?string $value): void
    {
        $this->fileName = $value;
    }

    /**
     * Sets the id property value. Document ID
     * @param string|null $value Value to set for the id property.
     */
    public function setId(?string $value): void
    {
        $this->id = $value;
    }

    /**
     * Sets the status property value. Processing status
     * @param KnowledgeDocumentStatus|null $value Value to set for the status property.
     */
    public function setStatus(?KnowledgeDocumentStatus $value): void
    {
        $this->status = $value;
    }
}
