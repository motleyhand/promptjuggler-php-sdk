<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;
use Microsoft\Kiota\Abstractions\Types\TypeUtils;

/**
 * A tool the model used: its name and how the call ended.
 */
class TranscriptTool implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var array<Citation>|null $citations Sources this call returned. Only ever populated by the built-in web_search tool.
     */
    private ?array $citations = null;
    
    /**
     * @var string|null $name Tool name, as the model called it.
     */
    private ?string $name = null;
    
    /**
     * @var array<string>|null $queries Search queries the model ran. Only ever populated by the built-in web_search tool.
     */
    private ?array $queries = null;
    
    /**
     * @var ToolStatus|null $status How the call ended.
     */
    private ?ToolStatus $status = null;
    
    /**
     * @var TranscriptTool_type|null $type The type property
     */
    private ?TranscriptTool_type $type = null;
    
    /**
     * Instantiates a new TranscriptTool and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): TranscriptTool
    {
        return new TranscriptTool();
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
     * Gets the citations property value. Sources this call returned. Only ever populated by the built-in web_search tool.
     * @return array<Citation>|null
     */
    public function getCitations(): ?array
    {
        return $this->citations;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'citations' => static fn (ParseNode $n) => $o->setCitations(
                $n->getCollectionOfObjectValues([Citation::class, 'createFromDiscriminatorValue']),
            ),
            'name' => static fn (ParseNode $n) => $o->setName($n->getStringValue()),
            'queries' => function (ParseNode $n) {
                $val = $n->getCollectionOfPrimitiveValues();
                if (\is_array($val)) {
                    TypeUtils::validateCollectionValues($val, 'string');
                }
                /** @var array<string>|null $val */
                $this->setQueries($val);
            },
            'status' => static fn (ParseNode $n) => $o->setStatus($n->getEnumValue(ToolStatus::class)),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(TranscriptTool_type::class)),
        ];
    }

    /**
     * Gets the name property value. Tool name, as the model called it.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the queries property value. Search queries the model ran. Only ever populated by the built-in web_search tool.
     * @return array<string>|null
     */
    public function getQueries(): ?array
    {
        return $this->queries;
    }

    /**
     * Gets the status property value. How the call ended.
     */
    public function getStatus(): ?ToolStatus
    {
        return $this->status;
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?TranscriptTool_type
    {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeCollectionOfObjectValues('citations', $this->getCitations());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeCollectionOfPrimitiveValues('queries', $this->getQueries());
        $writer->writeEnumValue('status', $this->getStatus());
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
     * Sets the citations property value. Sources this call returned. Only ever populated by the built-in web_search tool.
     * @param array<Citation>|null $value Value to set for the citations property.
     */
    public function setCitations(?array $value): void
    {
        $this->citations = $value;
    }

    /**
     * Sets the name property value. Tool name, as the model called it.
     * @param string|null $value Value to set for the name property.
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * Sets the queries property value. Search queries the model ran. Only ever populated by the built-in web_search tool.
     * @param array<string>|null $value Value to set for the queries property.
     */
    public function setQueries(?array $value): void
    {
        $this->queries = $value;
    }

    /**
     * Sets the status property value. How the call ended.
     * @param ToolStatus|null $value Value to set for the status property.
     */
    public function setStatus(?ToolStatus $value): void
    {
        $this->status = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param TranscriptTool_type|null $value Value to set for the type property.
     */
    public function setType(?TranscriptTool_type $value): void
    {
        $this->type = $value;
    }
}
