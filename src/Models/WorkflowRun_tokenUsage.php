<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes TokenUsage, WorkflowRun_tokenUsageMember1
 */
class WorkflowRun_tokenUsage implements ComposedTypeWrapper, Parsable
{
    /**
     * @var TokenUsage|null $tokenUsage Composed type representation for type TokenUsage
     */
    private ?TokenUsage $tokenUsage = null;
    
    /**
     * @var WorkflowRun_tokenUsageMember1|null $workflowRun_tokenUsageMember1 Composed type representation for type WorkflowRun_tokenUsageMember1
     */
    private ?WorkflowRun_tokenUsageMember1 $workflowRun_tokenUsageMember1 = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WorkflowRun_tokenUsage
    {
        $result = new WorkflowRun_tokenUsage();

        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        if ($this->getTokenUsage() !== null) {
            return $this->getTokenUsage()->getFieldDeserializers();
        } elseif ($this->getWorkflowRunTokenUsageMember1() !== null) {
            return $this->getWorkflowRunTokenUsageMember1()->getFieldDeserializers();
        }

        return [];
    }

    /**
     * Gets the TokenUsage property value. Composed type representation for type TokenUsage
     */
    public function getTokenUsage(): ?TokenUsage
    {
        return $this->tokenUsage;
    }

    /**
     * Gets the WorkflowRun_tokenUsageMember1 property value. Composed type representation for type WorkflowRun_tokenUsageMember1
     */
    public function getWorkflowRunTokenUsageMember1(): ?WorkflowRun_tokenUsageMember1
    {
        return $this->workflowRun_tokenUsageMember1;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        if ($this->getTokenUsage() !== null) {
            $writer->writeObjectValue(null, $this->getTokenUsage());
        } elseif ($this->getWorkflowRunTokenUsageMember1() !== null) {
            $writer->writeObjectValue(null, $this->getWorkflowRunTokenUsageMember1());
        }
    }

    /**
     * Sets the TokenUsage property value. Composed type representation for type TokenUsage
     * @param TokenUsage|null $value Value to set for the TokenUsage property.
     */
    public function setTokenUsage(?TokenUsage $value): void
    {
        $this->tokenUsage = $value;
    }

    /**
     * Sets the WorkflowRun_tokenUsageMember1 property value. Composed type representation for type WorkflowRun_tokenUsageMember1
     * @param WorkflowRun_tokenUsageMember1|null $value Value to set for the WorkflowRun_tokenUsageMember1 property.
     */
    public function setWorkflowRunTokenUsageMember1(?WorkflowRun_tokenUsageMember1 $value): void
    {
        $this->workflowRun_tokenUsageMember1 = $value;
    }
}
