<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

use DateTime;
use Microsoft\Kiota\Abstractions\Serialization\AdditionalDataHolder;
use Microsoft\Kiota\Abstractions\Serialization\Parsable;
use Microsoft\Kiota\Abstractions\Serialization\ParseNode;
use Microsoft\Kiota\Abstractions\Serialization\SerializationWriter;

/**
 * A short-lived credential for subscribing to a thread's token stream.
 */
class StreamTokenResponse implements AdditionalDataHolder, Parsable
{
    /**
     * @var array<string, mixed>|null $additionalData Stores additional data not described in the OpenAPI description found when deserializing. Can be used for serialization as well.
     */
    private ?array $additionalData = null;
    
    /**
     * @var DateTime|null $expiresAt Timestamp when the token stops being accepted.
     */
    private ?DateTime $expiresAt = null;
    
    /**
     * @var string|null $token Bearer token for the streaming endpoint. Safe to hand to a browser — it grants read access to this one thread and nothing else.
     */
    private ?string $token = null;
    
    /**
     * @var string|null $url Fully-resolved SSE endpoint for this thread. Connect here with the token as a Bearer credential.
     */
    private ?string $url = null;
    
    /**
     * Instantiates a new StreamTokenResponse and sets the default values.
     */
    public function __construct()
    {
        $this->setAdditionalData([]);
    }

    /**
     * Creates a new instance of the appropriate class based on discriminator value
     * @param ParseNode $parseNode The parse node to use to read the discriminator value and create the object
     */
    public static function createFromDiscriminatorValue(ParseNode $parseNode): StreamTokenResponse
    {
        return new StreamTokenResponse();
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
     * Gets the expiresAt property value. Timestamp when the token stops being accepted.
     */
    public function getExpiresAt(): ?DateTime
    {
        return $this->expiresAt;
    }

    /**
     * The deserialization information for the current model
     * @return array<string, callable(ParseNode): void>
     */
    public function getFieldDeserializers(): array
    {
        $o = $this;

        return [
            'expiresAt' => static fn (ParseNode $n) => $o->setExpiresAt($n->getDateTimeValue()),
            'token' => static fn (ParseNode $n) => $o->setToken($n->getStringValue()),
            'url' => static fn (ParseNode $n) => $o->setUrl($n->getStringValue()),
        ];
    }

    /**
     * Gets the token property value. Bearer token for the streaming endpoint. Safe to hand to a browser — it grants read access to this one thread and nothing else.
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Gets the url property value. Fully-resolved SSE endpoint for this thread. Connect here with the token as a Bearer credential.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Serializes information the current object
     * @param SerializationWriter $writer Serialization writer to use to serialize this model
     */
    public function serialize(SerializationWriter $writer): void
    {
        $writer->writeDateTimeValue('expiresAt', $this->getExpiresAt());
        $writer->writeStringValue('token', $this->getToken());
        $writer->writeStringValue('url', $this->getUrl());
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
     * Sets the expiresAt property value. Timestamp when the token stops being accepted.
     * @param DateTime|null $value Value to set for the expiresAt property.
     */
    public function setExpiresAt(?DateTime $value): void
    {
        $this->expiresAt = $value;
    }

    /**
     * Sets the token property value. Bearer token for the streaming endpoint. Safe to hand to a browser — it grants read access to this one thread and nothing else.
     * @param string|null $value Value to set for the token property.
     */
    public function setToken(?string $value): void
    {
        $this->token = $value;
    }

    /**
     * Sets the url property value. Fully-resolved SSE endpoint for this thread. Connect here with the token as a Bearer credential.
     * @param string|null $value Value to set for the url property.
     */
    public function setUrl(?string $value): void
    {
        $this->url = $value;
    }
}
