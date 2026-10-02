<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * JSON schema response format.
 */
final readonly class JsonSchemaFormat implements ResponseFormat
{
    /**
     * @param string $name Schema name.
     * @param string $schema The JSON schema as string.
     * @param 'json_schema' $type
     * @param bool|null $strict Whether the model should follow the schema strictly.
     * @param string|null $description Schema description.
     */
    public function __construct(
        public string $name,
        public string $schema,
        public string $type,
        public ?bool $strict = false,
        public ?string $description = null,
    ) {
    }
}
