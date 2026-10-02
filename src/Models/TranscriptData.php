<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use UnexpectedValueException;

/**
 * An emit-tool payload, in the position it was produced.
 */
class TranscriptData implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var TranscriptData_payload|null $payload The payload — the tool-call arguments, verbatim.
     */
    private ?TranscriptData_payload $payload = null;
    
    /**
     * @var string|null $tool The emit tool that produced this payload.
     */
    private ?string $tool = null;
    
    /**
     * @var TranscriptData_type|null $type The type property
     */
    private ?TranscriptData_type $type = null;
    
    /**
     * Instantiates a new TranscriptData and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TranscriptData
    {
        return new TranscriptData();
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
            'payload' => static fn (ParseNode $n) => $o->setPayload(
                $n->getObjectValue([TranscriptData_payload::class, 'createFromDiscriminatorValue']),
            ),
            'tool' => static fn (ParseNode $n) => $o->setTool($n->getStringValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(TranscriptData_type::class)),
        ];
    }

    /**
     * Gets the payload property value. The payload — the tool-call arguments, verbatim.
     */
    public function getPayload(): TranscriptData_payload
    {
        return $this->payload ?? throw new UnexpectedValueException(
            'Required field TranscriptData.payload is missing from the API response.',
        );
    }

    /**
     * Gets the tool property value. The emit tool that produced this payload.
     */
    public function getTool(): string
    {
        return $this->tool ?? throw new UnexpectedValueException(
            'Required field TranscriptData.tool is missing from the API response.',
        );
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): TranscriptData_type
    {
        return $this->type ?? throw new UnexpectedValueException(
            'Required field TranscriptData.type is missing from the API response.',
        );
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeObjectValue('payload', $this->getPayload());
        $writer->writeStringValue('tool', $this->getTool());
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
     * Sets the payload property value. The payload — the tool-call arguments, verbatim.
     * @param TranscriptData_payload|null $value Value to set for the payload property.
     */
    public function setPayload(?TranscriptData_payload $value): void
    {
        $this->payload = $value;
    }

    /**
     * Sets the tool property value. The emit tool that produced this payload.
     * @param string|null $value Value to set for the tool property.
     */
    public function setTool(?string $value): void
    {
        $this->tool = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param TranscriptData_type|null $value Value to set for the type property.
     */
    public function setType(?TranscriptData_type $value): void
    {
        $this->type = $value;
    }
}
