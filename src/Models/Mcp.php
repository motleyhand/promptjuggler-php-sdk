<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * Built-in MCP server tool.
 */
final readonly class Mcp implements Tool
{
    /**
     * @param string $name The MCP server tool’s name.
     * @param string $url The URL of the MCP server.
     * @param 'mcp' $type
     * @param string|null $authorizationToken Environment variable holding the MCP server’s authorization token, referenced as ${NAME}.
     * @param list<string>|null $allowedTools Tool names the model may call. Empty or omitted allows all of the server’s tools.
     */
    public function __construct(
        public string $name,
        public string $url,
        public string $type,
        public ?string $authorizationToken = null,
        public ?array $allowedTools = null,
    ) {
    }
}
