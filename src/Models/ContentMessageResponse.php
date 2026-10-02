<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Models;

/**
 * User or assistant message.
 */
final readonly class ContentMessageResponse
{
    /**
     * @param Role|UnknownEnumValue $role Message direction / role.
     * @param string $content Message content.
     */
    public function __construct(
        public Role|UnknownEnumValue $role,
        public string $content,
    ) {
    }
}
