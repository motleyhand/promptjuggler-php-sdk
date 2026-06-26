<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes RunCost, WorkflowRun_costMember1
 */
class WorkflowRun_cost implements ComposedTypeWrapper, Parsable
{
    /**
     * @var RunCost|null $runCost Composed type representation for type RunCost
     */
    private ?RunCost $runCost = null;
    
    /**
     * @var WorkflowRun_costMember1|null $workflowRun_costMember1 Composed type representation for type WorkflowRun_costMember1
     */
    private ?WorkflowRun_costMember1 $workflowRun_costMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WorkflowRun_cost
    {
        $result = new WorkflowRun_cost();

        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        if ($this->getRunCost() !== null) {
            return $this->getRunCost()->getFieldDeserializers();
        } elseif ($this->getWorkflowRunCostMember1() !== null) {
            return $this->getWorkflowRunCostMember1()->getFieldDeserializers();
        }

        return [];
    }

    /**
     * Gets the RunCost property value. Composed type representation for type RunCost
     */
    public function getRunCost(): ?RunCost
    {
        return $this->runCost;
    }

    /**
     * Gets the WorkflowRun_costMember1 property value. Composed type representation for type WorkflowRun_costMember1
     */
    public function getWorkflowRunCostMember1(): ?WorkflowRun_costMember1
    {
        return $this->workflowRun_costMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        if ($this->getRunCost() !== null) {
            $writer->writeObjectValue(null, $this->getRunCost());
        } elseif ($this->getWorkflowRunCostMember1() !== null) {
            $writer->writeObjectValue(null, $this->getWorkflowRunCostMember1());
        }
    }

    /**
     * Sets the RunCost property value. Composed type representation for type RunCost
     * @param RunCost|null $value Value to set for the RunCost property.
     */
    public function setRunCost(?RunCost $value): void
    {
        $this->runCost = $value;
    }

    /**
     * Sets the WorkflowRun_costMember1 property value. Composed type representation for type WorkflowRun_costMember1
     * @param WorkflowRun_costMember1|null $value Value to set for the WorkflowRun_costMember1 property.
     */
    public function setWorkflowRunCostMember1(?WorkflowRun_costMember1 $value): void
    {
        $this->workflowRun_costMember1 = $value;
    }
}
