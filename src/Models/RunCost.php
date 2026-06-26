<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class RunCost implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var ModelCost|null $retries The retries property
     */
    private ?ModelCost $retries = null;
    
    /**
     * @var ModelCost|null $success The success property
     */
    private ?ModelCost $success = null;
    
    /**
     * @var float|null $total The total property
     */
    private ?float $total = null;
    
    /**
     * Instantiates a new RunCost and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): RunCost
    {
        return new RunCost();
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
            'retries' => static fn (ParseNode $n) => $o->setRetries(
                $n->getObjectValue([ModelCost::class, 'createFromDiscriminatorValue']),
            ),
            'success' => static fn (ParseNode $n) => $o->setSuccess(
                $n->getObjectValue([ModelCost::class, 'createFromDiscriminatorValue']),
            ),
            'total' => static fn (ParseNode $n) => $o->setTotal($n->getFloatValue()),
        ];
    }

    /**
     * Gets the retries property value. The retries property
     */
    public function getRetries(): ?ModelCost
    {
        return $this->retries;
    }

    /**
     * Gets the success property value. The success property
     */
    public function getSuccess(): ?ModelCost
    {
        return $this->success;
    }

    /**
     * Gets the total property value. The total property
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeObjectValue('retries', $this->getRetries());
        $writer->writeObjectValue('success', $this->getSuccess());
        $writer->writeFloatValue('total', $this->getTotal());
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
     * Sets the retries property value. The retries property
     * @param ModelCost|null $value Value to set for the retries property.
     */
    public function setRetries(?ModelCost $value): void
    {
        $this->retries = $value;
    }

    /**
     * Sets the success property value. The success property
     * @param ModelCost|null $value Value to set for the success property.
     */
    public function setSuccess(?ModelCost $value): void
    {
        $this->success = $value;
    }

    /**
     * Sets the total property value. The total property
     * @param float|null $value Value to set for the total property.
     */
    public function setTotal(?float $value): void
    {
        $this->total = $value;
    }
}
