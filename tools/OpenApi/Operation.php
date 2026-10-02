<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

final readonly class Operation
{
    /**
     * @param array<int|string, Response> $responses By status code, which JSON decoding turns into an int.
     */
    public function __construct(
        public array $responses,
        public ?RequestBody $requestBody = null,
        public ?string $operationId = null,
    ) {
    }
}
