<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes PromptRun_costMember1, RunCost
 */
class PromptRun_cost implements ComposedTypeWrapper, Parsable
{
    /**
     * @var PromptRun_costMember1|null $promptRun_costMember1 Composed type representation for type PromptRun_costMember1
     */
    private ?PromptRun_costMember1 $promptRun_costMember1 = null;
    
    /**
     * @var RunCost|null $runCost Composed type representation for type RunCost
     */
    private ?RunCost $runCost = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PromptRun_cost
    {
        $result = new PromptRun_cost();

        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        if ($this->getPromptRunCostMember1() !== null) {
            return $this->getPromptRunCostMember1()->getFieldDeserializers();
        } elseif ($this->getRunCost() !== null) {
            return $this->getRunCost()->getFieldDeserializers();
        }

        return [];
    }

    /**
     * Gets the PromptRun_costMember1 property value. Composed type representation for type PromptRun_costMember1
     */
    public function getPromptRunCostMember1(): ?PromptRun_costMember1
    {
        return $this->promptRun_costMember1;
    }

    /**
     * Gets the RunCost property value. Composed type representation for type RunCost
     */
    public function getRunCost(): ?RunCost
    {
        return $this->runCost;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        if ($this->getPromptRunCostMember1() !== null) {
            $writer->writeObjectValue(null, $this->getPromptRunCostMember1());
        } elseif ($this->getRunCost() !== null) {
            $writer->writeObjectValue(null, $this->getRunCost());
        }
    }

    /**
     * Sets the PromptRun_costMember1 property value. Composed type representation for type PromptRun_costMember1
     * @param PromptRun_costMember1|null $value Value to set for the PromptRun_costMember1 property.
     */
    public function setPromptRunCostMember1(?PromptRun_costMember1 $value): void
    {
        $this->promptRun_costMember1 = $value;
    }

    /**
     * Sets the RunCost property value. Composed type representation for type RunCost
     * @param RunCost|null $value Value to set for the RunCost property.
     */
    public function setRunCost(?RunCost $value): void
    {
        $this->runCost = $value;
    }
}
