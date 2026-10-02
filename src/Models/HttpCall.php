<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * External HTTP call tool.
 */
final readonly class HttpCall implements Tool
{
    /**
     * @param string $paramsSchema JSON schema of the parameters this tool expects.
     * @param string $url The URL to call. Can contain ${ENV_VAR} and {{inputName}} placeholders.
     * @param string $name The tool’s name.
     * @param bool $failFast Whether to stop processing if a tool call fails.
     * @param 'http' $type
     * @param list<HttpHeader> $headers The headers to send with the HTTP request. Can contain ${ENV_VAR} and {{inputName}} placeholders; a credential header (Authorization, *-Key, *-Token, …) must take its secret from one.
     * @param string|null $description The tool’s description.
     */
    public function __construct(
        public string $paramsSchema,
        public string $url,
        public HttpCallMethod|UnknownEnumValue $method,
        public string $name,
        public bool $failFast,
        public string $type,
        public array $headers = [],
        public ?string $description = null,
    ) {
    }
}
