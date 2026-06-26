<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class TokenUsage implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var int|null $input The input property
     */
    private ?int $input = null;
    
    /**
     * @var int|null $inputCached The inputCached property
     */
    private ?int $inputCached = null;
    
    /**
     * @var int|null $output The output property
     */
    private ?int $output = null;
    
    /**
     * @var int|null $reasoning The reasoning property
     */
    private ?int $reasoning = null;
    
    /**
     * @var ServiceTier|null $serviceTier The serviceTier property
     */
    private ?ServiceTier $serviceTier = null;
    
    /**
     * @var int|null $total The total property
     */
    private ?int $total = null;
    
    /**
     * Instantiates a new TokenUsage and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TokenUsage
    {
        return new TokenUsage();
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
            'input' => static fn (ParseNode $n) => $o->setInput($n->getIntegerValue()),
            'inputCached' => static fn (ParseNode $n) => $o->setInputCached($n->getIntegerValue()),
            'output' => static fn (ParseNode $n) => $o->setOutput($n->getIntegerValue()),
            'reasoning' => static fn (ParseNode $n) => $o->setReasoning($n->getIntegerValue()),
            'serviceTier' => static fn (ParseNode $n) => $o->setServiceTier($n->getEnumValue(ServiceTier::class)),
            'total' => static fn (ParseNode $n) => $o->setTotal($n->getIntegerValue()),
        ];
    }

    /**
     * Gets the input property value. The input property
     */
    public function getInput(): ?int
    {
        return $this->input;
    }

    /**
     * Gets the inputCached property value. The inputCached property
     */
    public function getInputCached(): ?int
    {
        return $this->inputCached;
    }

    /**
     * Gets the output property value. The output property
     */
    public function getOutput(): ?int
    {
        return $this->output;
    }

    /**
     * Gets the reasoning property value. The reasoning property
     */
    public function getReasoning(): ?int
    {
        return $this->reasoning;
    }

    /**
     * Gets the serviceTier property value. The serviceTier property
     */
    public function getServiceTier(): ?ServiceTier
    {
        return $this->serviceTier;
    }

    /**
     * Gets the total property value. The total property
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeIntegerValue('input', $this->getInput());
        $writer->writeIntegerValue('inputCached', $this->getInputCached());
        $writer->writeIntegerValue('output', $this->getOutput());
        $writer->writeIntegerValue('reasoning', $this->getReasoning());
        $writer->writeEnumValue('serviceTier', $this->getServiceTier());
        $writer->writeIntegerValue('total', $this->getTotal());
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
     * Sets the input property value. The input property
     * @param int|null $value Value to set for the input property.
     */
    public function setInput(?int $value): void
    {
        $this->input = $value;
    }

    /**
     * Sets the inputCached property value. The inputCached property
     * @param int|null $value Value to set for the inputCached property.
     */
    public function setInputCached(?int $value): void
    {
        $this->inputCached = $value;
    }

    /**
     * Sets the output property value. The output property
     * @param int|null $value Value to set for the output property.
     */
    public function setOutput(?int $value): void
    {
        $this->output = $value;
    }

    /**
     * Sets the reasoning property value. The reasoning property
     * @param int|null $value Value to set for the reasoning property.
     */
    public function setReasoning(?int $value): void
    {
        $this->reasoning = $value;
    }

    /**
     * Sets the serviceTier property value. The serviceTier property
     * @param ServiceTier|null $value Value to set for the serviceTier property.
     */
    public function setServiceTier(?ServiceTier $value): void
    {
        $this->serviceTier = $value;
    }

    /**
     * Sets the total property value. The total property
     * @param int|null $value Value to set for the total property.
     */
    public function setTotal(?int $value): void
    {
        $this->total = $value;
    }
}
