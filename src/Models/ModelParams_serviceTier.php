<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\ComposedTypeWrapper;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Composed type wrapper for classes ModelParams_serviceTierMember1, ServiceTier
*/
class ModelParams_serviceTier implements ComposedTypeWrapper, Parsable 
{
    /**
     * @var ModelParams_serviceTierMember1|null $modelParams_serviceTierMember1 Composed type representation for type ModelParams_serviceTierMember1
    */
    private ?ModelParams_serviceTierMember1 $modelParams_serviceTierMember1 = null;
    
    /**
     * @var ServiceTier|null $serviceTier Composed type representation for type ServiceTier
    */
    private ?ServiceTier $serviceTier = null;
    
    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     * @return ModelParams_serviceTier
    */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): ModelParams_serviceTier {
        $result = new ModelParams_serviceTier();
        if ($parseNode->getEnumValue(ServiceTier::class) !== null) {
            $finalValue = $parseNode->getEnumValue(ServiceTier::class);
            $result->setServiceTier($finalValue);
        }
        return $result;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
    */
    public function getFieldDeserializers(): array {
        if ($this->getModelParamsServiceTierMember1() !== null) {
            return $this->getModelParamsServiceTierMember1()->getFieldDeserializers();
        }
        return [];
    }

    /**
     * Gets the ModelParams_serviceTierMember1 property value. Composed type representation for type ModelParams_serviceTierMember1
     * @return ModelParams_serviceTierMember1|null
    */
    public function getModelParamsServiceTierMember1(): ?ModelParams_serviceTierMember1 {
        return $this->modelParams_serviceTierMember1;
    }

    /**
     * Gets the ServiceTier property value. Composed type representation for type ServiceTier
     * @return ServiceTier|null
    */
    public function getServiceTier(): ?ServiceTier {
        return $this->serviceTier;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
    */
    public function serialize(SerializationWriter $writer): void {
        if ($this->getModelParamsServiceTierMember1() !== null) {
            $writer->writeObjectValue(null, $this->getModelParamsServiceTierMember1());
        } else if ($this->getServiceTier() !== null) {
            $writer->writeEnumValue(null, $this->getServiceTier());
        }
    }

    /**
     * Sets the ModelParams_serviceTierMember1 property value. Composed type representation for type ModelParams_serviceTierMember1
     * @param ModelParams_serviceTierMember1|null $value Value to set for the ModelParams_serviceTierMember1 property.
    */
    public function setModelParamsServiceTierMember1(?ModelParams_serviceTierMember1 $value): void {
        $this->modelParams_serviceTierMember1 = $value;
    }

    /**
     * Sets the ServiceTier property value. Composed type representation for type ServiceTier
     * @param ServiceTier|null $value Value to set for the ServiceTier property.
    */
    public function setServiceTier(?ServiceTier $value): void {
        $this->serviceTier = $value;
    }

}
