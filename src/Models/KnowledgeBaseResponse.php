<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Knowledge base with documents
 */
class KnowledgeBaseResponse implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var int|null $chunkCount Total number of chunks across all documents
     */
    private ?int $chunkCount = null;
    
    /**
     * @var int|null $documentCount Total number of documents
     */
    private ?int $documentCount = null;
    
    /**
     * @var array<KnowledgeDocumentSummary>|null $documents The documents property
     */
    private ?array $documents = null;
    
    /**
     * @var string|null $id Knowledge base ID
     */
    private ?string $id = null;
    
    /**
     * @var KnowledgeBaseStatus|null $status Processing status
     */
    private ?KnowledgeBaseStatus $status = null;
    
    /**
     * Instantiates a new KnowledgeBaseResponse and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): KnowledgeBaseResponse
    {
        return new KnowledgeBaseResponse();
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
     * Gets the chunkCount property value. Total number of chunks across all documents
     */
    public function getChunkCount(): ?int
    {
        return $this->chunkCount;
    }

    /**
     * Gets the documentCount property value. Total number of documents
     */
    public function getDocumentCount(): ?int
    {
        return $this->documentCount;
    }

    /**
     * Gets the documents property value. The documents property
     * @return array<KnowledgeDocumentSummary>|null
     */
    public function getDocuments(): ?array
    {
        return $this->documents;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'chunkCount' => static fn (ParseNode $n) => $o->setChunkCount($n->getIntegerValue()),
            'documentCount' => static fn (ParseNode $n) => $o->setDocumentCount($n->getIntegerValue()),
            'documents' => static fn (ParseNode $n) => $o->setDocuments(
                $n->getCollectionOfObjectValues([KnowledgeDocumentSummary::class, 'createFromDiscriminatorValue']),
            ),
            'id' => static fn (ParseNode $n) => $o->setId($n->getStringValue()),
            'status' => static fn (ParseNode $n) => $o->setStatus($n->getEnumValue(KnowledgeBaseStatus::class)),
        ];
    }

    /**
     * Gets the id property value. Knowledge base ID
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Gets the status property value. Processing status
     */
    public function getStatus(): ?KnowledgeBaseStatus
    {
        return $this->status;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeIntegerValue('chunkCount', $this->getChunkCount());
        $writer->writeIntegerValue('documentCount', $this->getDocumentCount());
        $writer->writeCollectionOfObjectValues('documents', $this->getDocuments());
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
     * Sets the chunkCount property value. Total number of chunks across all documents
     * @param int|null $value Value to set for the chunkCount property.
     */
    public function setChunkCount(?int $value): void
    {
        $this->chunkCount = $value;
    }

    /**
     * Sets the documentCount property value. Total number of documents
     * @param int|null $value Value to set for the documentCount property.
     */
    public function setDocumentCount(?int $value): void
    {
        $this->documentCount = $value;
    }

    /**
     * Sets the documents property value. The documents property
     * @param array<KnowledgeDocumentSummary>|null $value Value to set for the documents property.
     */
    public function setDocuments(?array $value): void
    {
        $this->documents = $value;
    }

    /**
     * Sets the id property value. Knowledge base ID
     * @param string|null $value Value to set for the id property.
     */
    public function setId(?string $value): void
    {
        $this->id = $value;
    }

    /**
     * Sets the status property value. Processing status
     * @param KnowledgeBaseStatus|null $value Value to set for the status property.
     */
    public function setStatus(?KnowledgeBaseStatus $value): void
    {
        $this->status = $value;
    }
}
