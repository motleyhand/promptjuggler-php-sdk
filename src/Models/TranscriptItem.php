<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes TranscriptData, TranscriptText, TranscriptTool
 */
class TranscriptItem implements ComposedTypeWrapper, Parsable
{
    /**
     * @var TranscriptData|null $transcriptData Composed type representation for type TranscriptData
     */
    private ?TranscriptData $transcriptData = null;
    
    /**
     * @var TranscriptText|null $transcriptText Composed type representation for type TranscriptText
     */
    private ?TranscriptText $transcriptText = null;
    
    /**
     * @var TranscriptTool|null $transcriptTool Composed type representation for type TranscriptTool
     */
    private ?TranscriptTool $transcriptTool = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TranscriptItem
    {
        $result = new TranscriptItem();
        $mappingValueNode = $parseNode->getChildNode('type');
        if ($mappingValueNode !== null) {
            $mappingValue = $mappingValueNode->getStringValue();
            if ('data' === $mappingValue) {
                $result->setTranscriptData(new TranscriptData());
            } elseif ('text' === $mappingValue) {
                $result->setTranscriptText(new TranscriptText());
            } elseif ('tool' === $mappingValue) {
                $result->setTranscriptTool(new TranscriptTool());
            }
        }

        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        if ($this->getTranscriptData() !== null) {
            return $this->getTranscriptData()->getFieldDeserializers();
        } elseif ($this->getTranscriptText() !== null) {
            return $this->getTranscriptText()->getFieldDeserializers();
        } elseif ($this->getTranscriptTool() !== null) {
            return $this->getTranscriptTool()->getFieldDeserializers();
        }

        return [];
    }

    /**
     * Gets the TranscriptData property value. Composed type representation for type TranscriptData
     */
    public function getTranscriptData(): ?TranscriptData
    {
        return $this->transcriptData;
    }

    /**
     * Gets the TranscriptText property value. Composed type representation for type TranscriptText
     */
    public function getTranscriptText(): ?TranscriptText
    {
        return $this->transcriptText;
    }

    /**
     * Gets the TranscriptTool property value. Composed type representation for type TranscriptTool
     */
    public function getTranscriptTool(): ?TranscriptTool
    {
        return $this->transcriptTool;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        if ($this->getTranscriptData() !== null) {
            $writer->writeObjectValue(null, $this->getTranscriptData());
        } elseif ($this->getTranscriptText() !== null) {
            $writer->writeObjectValue(null, $this->getTranscriptText());
        } elseif ($this->getTranscriptTool() !== null) {
            $writer->writeObjectValue(null, $this->getTranscriptTool());
        }
    }

    /**
     * Sets the TranscriptData property value. Composed type representation for type TranscriptData
     * @param TranscriptData|null $value Value to set for the TranscriptData property.
     */
    public function setTranscriptData(?TranscriptData $value): void
    {
        $this->transcriptData = $value;
    }

    /**
     * Sets the TranscriptText property value. Composed type representation for type TranscriptText
     * @param TranscriptText|null $value Value to set for the TranscriptText property.
     */
    public function setTranscriptText(?TranscriptText $value): void
    {
        $this->transcriptText = $value;
    }

    /**
     * Sets the TranscriptTool property value. Composed type representation for type TranscriptTool
     * @param TranscriptTool|null $value Value to set for the TranscriptTool property.
     */
    public function setTranscriptTool(?TranscriptTool $value): void
    {
        $this->transcriptTool = $value;
    }
}
