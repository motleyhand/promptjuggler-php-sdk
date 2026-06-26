<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes PromptRun_tokenUsageMember1, TokenUsage
 */
class PromptRun_tokenUsage implements ComposedTypeWrapper, Parsable
{
    /**
     * @var PromptRun_tokenUsageMember1|null $promptRun_tokenUsageMember1 Composed type representation for type PromptRun_tokenUsageMember1
     */
    private ?PromptRun_tokenUsageMember1 $promptRun_tokenUsageMember1 = null;
    
    /**
     * @var TokenUsage|null $tokenUsage Composed type representation for type TokenUsage
     */
    private ?TokenUsage $tokenUsage = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): PromptRun_tokenUsage
    {
        $result = new PromptRun_tokenUsage();

        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        if ($this->getPromptRunTokenUsageMember1() !== null) {
            return $this->getPromptRunTokenUsageMember1()->getFieldDeserializers();
        } elseif ($this->getTokenUsage() !== null) {
            return $this->getTokenUsage()->getFieldDeserializers();
        }

        return [];
    }

    /**
     * Gets the PromptRun_tokenUsageMember1 property value. Composed type representation for type PromptRun_tokenUsageMember1
     */
    public function getPromptRunTokenUsageMember1(): ?PromptRun_tokenUsageMember1
    {
        return $this->promptRun_tokenUsageMember1;
    }

    /**
     * Gets the TokenUsage property value. Composed type representation for type TokenUsage
     */
    public function getTokenUsage(): ?TokenUsage
    {
        return $this->tokenUsage;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        if ($this->getPromptRunTokenUsageMember1() !== null) {
            $writer->writeObjectValue(null, $this->getPromptRunTokenUsageMember1());
        } elseif ($this->getTokenUsage() !== null) {
            $writer->writeObjectValue(null, $this->getTokenUsage());
        }
    }

    /**
     * Sets the PromptRun_tokenUsageMember1 property value. Composed type representation for type PromptRun_tokenUsageMember1
     * @param PromptRun_tokenUsageMember1|null $value Value to set for the PromptRun_tokenUsageMember1 property.
     */
    public function setPromptRunTokenUsageMember1(?PromptRun_tokenUsageMember1 $value): void
    {
        $this->promptRun_tokenUsageMember1 = $value;
    }

    /**
     * Sets the TokenUsage property value. Composed type representation for type TokenUsage
     * @param TokenUsage|null $value Value to set for the TokenUsage property.
     */
    public function setTokenUsage(?TokenUsage $value): void
    {
        $this->tokenUsage = $value;
    }
}
