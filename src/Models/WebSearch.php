<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * Built-in web search.
 */
class WebSearch implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var array<string>|null $allowedDomains The allowedDomains property
     */
    private ?array $allowedDomains = null;
    
    /**
     * @var WebSearch_type|null $type The type property
     */
    private ?WebSearch_type $type = null;
    
    /**
     * Instantiates a new WebSearch and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): WebSearch
    {
        return new WebSearch();
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
     * Gets the allowedDomains property value. The allowedDomains property
     * @return array<string>|null
     */
    public function getAllowedDomains(): ?array
    {
        return $this->allowedDomains;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'allowedDomains' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (\is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setAllowedDomains($val);
            },
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(WebSearch_type::class)),
        ];
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?WebSearch_type
    {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeCollectionOfPrimitiveValues('allowedDomains', $this->getAllowedDomains());
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
     * Sets the allowedDomains property value. The allowedDomains property
     * @param array<string>|null $value Value to set for the allowedDomains property.
     */
    public function setAllowedDomains(?array $value): void
    {
        $this->allowedDomains = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param WebSearch_type|null $value Value to set for the type property.
     */
    public function setType(?WebSearch_type $value): void
    {
        $this->type = $value;
    }
}
