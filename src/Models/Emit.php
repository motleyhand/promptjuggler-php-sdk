<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * Emit a schema-validated payload: the arguments are the result.
 */
class Emit implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var string|null $description The tool’s description.
     */
    private ?string $description = null;
    
    /**
     * @var bool|null $failFast Whether to stop processing if a tool call fails.
     */
    private ?bool $failFast = null;
    
    /**
     * @var bool|null $inline Whether to also splice the payload into the output text as an emit:<name> markdown fence at the call position.
     */
    private ?bool $inline = null;
    
    /**
     * @var string|null $name The tool’s name.
     */
    private ?string $name = null;
    
    /**
     * @var string|null $paramsSchema JSON schema of the payload this tool emits.
     */
    private ?string $paramsSchema = null;
    
    /**
     * @var Emit_type|null $type The type property
     */
    private ?Emit_type $type = null;
    
    /**
     * Instantiates a new Emit and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
        $this->setFailFast(false);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): Emit
    {
        return new Emit();
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
     * Gets the description property value. The tool’s description.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Gets the failFast property value. Whether to stop processing if a tool call fails.
     */
    public function getFailFast(): ?bool
    {
        return $this->failFast;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'description' => static fn (ParseNode $n) => $o->setDescription($n->getStringValue()),
            'failFast' => static fn (ParseNode $n) => $o->setFailFast($n->getBooleanValue()),
            'inline' => static fn (ParseNode $n) => $o->setInline($n->getBooleanValue()),
            'name' => static fn (ParseNode $n) => $o->setName($n->getStringValue()),
            'paramsSchema' => static fn (ParseNode $n) => $o->setParamsSchema($n->getStringValue()),
            'type' => static fn (ParseNode $n) => $o->setType($n->getEnumValue(Emit_type::class)),
        ];
    }

    /**
     * Gets the inline property value. Whether to also splice the payload into the output text as an emit:<name> markdown fence at the call position.
     */
    public function getInline(): ?bool
    {
        return $this->inline;
    }

    /**
     * Gets the name property value. The tool’s name.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the paramsSchema property value. JSON schema of the payload this tool emits.
     */
    public function getParamsSchema(): ?string
    {
        return $this->paramsSchema;
    }

    /**
     * Gets the type property value. The type property
     */
    public function getType(): ?Emit_type
    {
        return $this->type;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeStringValue('description', $this->getDescription());
        $writer->writeBooleanValue('failFast', $this->getFailFast());
        $writer->writeBooleanValue('inline', $this->getInline());
        $writer->writeStringValue('name', $this->getName());
        $writer->writeStringValue('paramsSchema', $this->getParamsSchema());
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
     * Sets the description property value. The tool’s description.
     * @param string|null $value Value to set for the description property.
     */
    public function setDescription(?string $value): void
    {
        $this->description = $value;
    }

    /**
     * Sets the failFast property value. Whether to stop processing if a tool call fails.
     * @param bool|null $value Value to set for the failFast property.
     */
    public function setFailFast(?bool $value): void
    {
        $this->failFast = $value;
    }

    /**
     * Sets the inline property value. Whether to also splice the payload into the output text as an emit:<name> markdown fence at the call position.
     * @param bool|null $value Value to set for the inline property.
     */
    public function setInline(?bool $value): void
    {
        $this->inline = $value;
    }

    /**
     * Sets the name property value. The tool’s name.
     * @param string|null $value Value to set for the name property.
     */
    public function setName(?string $value): void
    {
        $this->name = $value;
    }

    /**
     * Sets the paramsSchema property value. JSON schema of the payload this tool emits.
     * @param string|null $value Value to set for the paramsSchema property.
     */
    public function setParamsSchema(?string $value): void
    {
        $this->paramsSchema = $value;
    }

    /**
     * Sets the type property value. The type property
     * @param Emit_type|null $value Value to set for the type property.
     */
    public function setType(?Emit_type $value): void
    {
        $this->type = $value;
    }
}
