<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes HttpCall, KnowledgeSearch, Mcp, PromptCall, ScriptCall, WebSearch, WorkflowCall
*/
class Tool implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var HttpCall|null $httpCall Composed type representation for type HttpCall
    */
    private ?HttpCall $httpCall = null;
    
    /**
     * @var KnowledgeSearch|null $knowledgeSearch Composed type representation for type KnowledgeSearch
    */
    private ?KnowledgeSearch $knowledgeSearch = null;
    
    /**
     * @var Mcp|null $mcp Composed type representation for type Mcp
    */
    private ?Mcp $mcp = null;
    
    /**
     * @var PromptCall|null $promptCall Composed type representation for type PromptCall
    */
    private ?PromptCall $promptCall = null;
    
    /**
     * @var ScriptCall|null $scriptCall Composed type representation for type ScriptCall
    */
    private ?ScriptCall $scriptCall = null;
    
    /**
     * @var WebSearch|null $webSearch Composed type representation for type WebSearch
    */
    private ?WebSearch $webSearch = null;
    
    /**
     * @var WorkflowCall|null $workflowCall Composed type representation for type WorkflowCall
    */
    private ?WorkflowCall $workflowCall = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return Tool
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): Tool {
        $result = new Tool();
        $mappingValueNode = $parseNode->getChildNode("type");
        if ($mappingValueNode !== null) {
            $mappingValue = $mappingValueNode->getStringValue();
            if ('http' === $mappingValue) {
                $result->setHttpCall(new HttpCall());
            } else if ('knowledge_search' === $mappingValue) {
                $result->setKnowledgeSearch(new KnowledgeSearch());
            } else if ('mcp' === $mappingValue) {
                $result->setMcp(new Mcp());
            } else if ('prompt' === $mappingValue) {
                $result->setPromptCall(new PromptCall());
            } else if ('script' === $mappingValue) {
                $result->setScriptCall(new ScriptCall());
            } else if ('web_search' === $mappingValue) {
                $result->setWebSearch(new WebSearch());
            } else if ('workflow' === $mappingValue) {
                $result->setWorkflowCall(new WorkflowCall());
            }
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getHttpCall() !== null) {
            return $this->getHttpCall()->getFieldDeserializers();
        } else if ($this->getKnowledgeSearch() !== null) {
            return $this->getKnowledgeSearch()->getFieldDeserializers();
        } else if ($this->getMcp() !== null) {
            return $this->getMcp()->getFieldDeserializers();
        } else if ($this->getPromptCall() !== null) {
            return $this->getPromptCall()->getFieldDeserializers();
        } else if ($this->getScriptCall() !== null) {
            return $this->getScriptCall()->getFieldDeserializers();
        } else if ($this->getWebSearch() !== null) {
            return $this->getWebSearch()->getFieldDeserializers();
        } else if ($this->getWorkflowCall() !== null) {
            return $this->getWorkflowCall()->getFieldDeserializers();
        }
        return [];
    }

    /**
     * Gets the HttpCall property value. Composed type representation for type HttpCall
     * @return HttpCall|null
    */
    public function getHttpCall(): ?HttpCall {
        return $this->httpCall;
    }

    /**
     * Gets the KnowledgeSearch property value. Composed type representation for type KnowledgeSearch
     * @return KnowledgeSearch|null
    */
    public function getKnowledgeSearch(): ?KnowledgeSearch {
        return $this->knowledgeSearch;
    }

    /**
     * Gets the Mcp property value. Composed type representation for type Mcp
     * @return Mcp|null
    */
    public function getMcp(): ?Mcp {
        return $this->mcp;
    }

    /**
     * Gets the PromptCall property value. Composed type representation for type PromptCall
     * @return PromptCall|null
    */
    public function getPromptCall(): ?PromptCall {
        return $this->promptCall;
    }

    /**
     * Gets the ScriptCall property value. Composed type representation for type ScriptCall
     * @return ScriptCall|null
    */
    public function getScriptCall(): ?ScriptCall {
        return $this->scriptCall;
    }

    /**
     * Gets the WebSearch property value. Composed type representation for type WebSearch
     * @return WebSearch|null
    */
    public function getWebSearch(): ?WebSearch {
        return $this->webSearch;
    }

    /**
     * Gets the WorkflowCall property value. Composed type representation for type WorkflowCall
     * @return WorkflowCall|null
    */
    public function getWorkflowCall(): ?WorkflowCall {
        return $this->workflowCall;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getHttpCall() !== null) {
            $writer->writeObjectValue(null, $this->getHttpCall());
        } else if ($this->getKnowledgeSearch() !== null) {
            $writer->writeObjectValue(null, $this->getKnowledgeSearch());
        } else if ($this->getMcp() !== null) {
            $writer->writeObjectValue(null, $this->getMcp());
        } else if ($this->getPromptCall() !== null) {
            $writer->writeObjectValue(null, $this->getPromptCall());
        } else if ($this->getScriptCall() !== null) {
            $writer->writeObjectValue(null, $this->getScriptCall());
        } else if ($this->getWebSearch() !== null) {
            $writer->writeObjectValue(null, $this->getWebSearch());
        } else if ($this->getWorkflowCall() !== null) {
            $writer->writeObjectValue(null, $this->getWorkflowCall());
        }
    }

    /**
     * Sets the HttpCall property value. Composed type representation for type HttpCall
     * @param HttpCall|null $value Value to set for the HttpCall property.
    */
    public function setHttpCall(?HttpCall $value): void {
        $this->httpCall = $value;
    }

    /**
     * Sets the KnowledgeSearch property value. Composed type representation for type KnowledgeSearch
     * @param KnowledgeSearch|null $value Value to set for the KnowledgeSearch property.
    */
    public function setKnowledgeSearch(?KnowledgeSearch $value): void {
        $this->knowledgeSearch = $value;
    }

    /**
     * Sets the Mcp property value. Composed type representation for type Mcp
     * @param Mcp|null $value Value to set for the Mcp property.
    */
    public function setMcp(?Mcp $value): void {
        $this->mcp = $value;
    }

    /**
     * Sets the PromptCall property value. Composed type representation for type PromptCall
     * @param PromptCall|null $value Value to set for the PromptCall property.
    */
    public function setPromptCall(?PromptCall $value): void {
        $this->promptCall = $value;
    }

    /**
     * Sets the ScriptCall property value. Composed type representation for type ScriptCall
     * @param ScriptCall|null $value Value to set for the ScriptCall property.
    */
    public function setScriptCall(?ScriptCall $value): void {
        $this->scriptCall = $value;
    }

    /**
     * Sets the WebSearch property value. Composed type representation for type WebSearch
     * @param WebSearch|null $value Value to set for the WebSearch property.
    */
    public function setWebSearch(?WebSearch $value): void {
        $this->webSearch = $value;
    }

    /**
     * Sets the WorkflowCall property value. Composed type representation for type WorkflowCall
     * @param WorkflowCall|null $value Value to set for the WorkflowCall property.
    */
    public function setWorkflowCall(?WorkflowCall $value): void {
        $this->workflowCall = $value;
    }

}
