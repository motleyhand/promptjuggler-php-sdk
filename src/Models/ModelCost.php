<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

class ModelCost implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var float|null $cachedInput The cachedInput property
     */
    private ?float $cachedInput = null;
    
    /**
     * @var float|null $input The input property
     */
    private ?float $input = null;
    
    /**
     * @var float|null $output The output property
     */
    private ?float $output = null;
    
    /**
     * @var float|null $total The total property
     */
    private ?float $total = null;
    
    /**
     * @var float|null $webSearch The webSearch property
     */
    private ?float $webSearch = null;
    
    /**
     * Instantiates a new ModelCost and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
        $this->setWebSearch(0);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ModelCost
    {
        return new ModelCost();
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
     * Gets the cachedInput property value. The cachedInput property
     */
    public function getCachedInput(): ?float
    {
        return $this->cachedInput;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'cachedInput' => static fn (ParseNode $n) => $o->setCachedInput($n->getFloatValue()),
            'input' => static fn (ParseNode $n) => $o->setInput($n->getFloatValue()),
            'output' => static fn (ParseNode $n) => $o->setOutput($n->getFloatValue()),
            'total' => static fn (ParseNode $n) => $o->setTotal($n->getFloatValue()),
            'webSearch' => static fn (ParseNode $n) => $o->setWebSearch($n->getFloatValue()),
        ];
    }

    /**
     * Gets the input property value. The input property
     */
    public function getInput(): ?float
    {
        return $this->input;
    }

    /**
     * Gets the output property value. The output property
     */
    public function getOutput(): ?float
    {
        return $this->output;
    }

    /**
     * Gets the total property value. The total property
     */
    public function getTotal(): ?float
    {
        return $this->total;
    }

    /**
     * Gets the webSearch property value. The webSearch property
     */
    public function getWebSearch(): ?float
    {
        return $this->webSearch;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeFloatValue('cachedInput', $this->getCachedInput());
        $writer->writeFloatValue('input', $this->getInput());
        $writer->writeFloatValue('output', $this->getOutput());
        $writer->writeFloatValue('total', $this->getTotal());
        $writer->writeFloatValue('webSearch', $this->getWebSearch());
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
     * Sets the cachedInput property value. The cachedInput property
     * @param float|null $value Value to set for the cachedInput property.
     */
    public function setCachedInput(?float $value): void
    {
        $this->cachedInput = $value;
    }

    /**
     * Sets the input property value. The input property
     * @param float|null $value Value to set for the input property.
     */
    public function setInput(?float $value): void
    {
        $this->input = $value;
    }

    /**
     * Sets the output property value. The output property
     * @param float|null $value Value to set for the output property.
     */
    public function setOutput(?float $value): void
    {
        $this->output = $value;
    }

    /**
     * Sets the total property value. The total property
     * @param float|null $value Value to set for the total property.
     */
    public function setTotal(?float $value): void
    {
        $this->total = $value;
    }

    /**
     * Sets the webSearch property value. The webSearch property
     * @param float|null $value Value to set for the webSearch property.
     */
    public function setWebSearch(?float $value): void
    {
        $this->webSearch = $value;
    }
}
