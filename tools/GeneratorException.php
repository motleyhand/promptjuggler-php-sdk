<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools;

use RuntimeException;

/**
 * The spec uses something the model generator doesn't support. The message starts with the schema path.
 */
final class GeneratorException extends RuntimeException
{
}
