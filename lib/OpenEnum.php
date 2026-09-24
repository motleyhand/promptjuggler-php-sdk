<?php

declare(strict_types=1);

namespace PromptJuggler\Client;

use Microsoft\Kiota\Abstractions\Enum;

/**
 * Base of the generated response enums. A value the API added after this SDK version decodes
 * instead of failing the whole response; `Model::has($model->value())` tells whether the SDK
 * declares it.
 */
abstract class OpenEnum extends Enum
{
    private string $value;

    // Skips Enum's constructor, which throws on an undeclared value. value() and is(), the only
    // readers of Enum's private copy, are overridden to read this one.
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function is(mixed $value): bool
    {
        return $this->value === $value;
    }
}
