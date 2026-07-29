<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * A block of assistant text.
 */
class TranscriptText implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var array<Citation>|null $citations Sources cited in this block, deduplicated by URL. Empty unless the model cited any.
     */
    private ?array $citations = null;
    
    /**
     * @var string|null $content The assistant text.
     */
    private ?string $content = null;
    
    /**
     * @var TranscriptText_type|null $type The type property
     */
    private ?TranscriptText_type $type = null;
    
    /**
     * Instantiates a new TranscriptText and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TranscriptText
    {
        return new TranscriptText();
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
     * Gets the citations property value. Sources cited in this block, deduplicated by URL. Empty unless the model cited any.
     * @return array<Citation>|null
     */
    public function getCitations(): ?array
    {
        return $this->citations;
    }

    /**
     * Gets the content property value. The assistant text.
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'citations' => static fn (ParseNode $n) => $o->setCitations(
                $n->getCollectionOfObjectValues([Citation::class, 'createFromDiscriminatorValue']),
            ),
            'content' => static fn (ParseNode $n) => $o->setContent($n->getStringValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(TranscriptText_type::class)),
        ];
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?TranscriptText_type
    {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeCollectionOfObjectValues('citations', $this->getCitations());
        $writer->writeStringValue('content', $this->getContent());
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
     * Sets the citations property value. Sources cited in this block, deduplicated by URL. Empty unless the model cited any.
     * @param array<Citation>|null $value Value to set for the citations property.
     */
    public function setCitations(?array $value): void
    {
        $this->citations = $value;
    }

    /**
     * Sets the content property value. The assistant text.
     * @param string|null $value Value to set for the content property.
     */
    public function setContent(?string $value): void
    {
        $this->content = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param TranscriptText_type|null $value Value to set for the type property.
     */
    public function setType(?TranscriptText_type $value): void
    {
        $this->type = $value;
    }
}
