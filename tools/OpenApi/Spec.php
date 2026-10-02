<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\MapperBuilder;
use Generator;
use PromptJuggler\Client\Tools\GeneratorException;

/**
 * The subset of an OpenAPI 3.1 document the model generator supports. Mapping fails, with the JSON
 * path, on what it doesn't.
 */
final readonly class Spec
{
    private const JSON = 'application/json';
    private const SCHEMA_REF = '#/components/schemas/';

    /**
     * @param array<string, array<string, Operation>> $paths
     * @param array{schemas: array<string, Schema>} $components
     */
    public function __construct(
        public array $paths,
        public array $components,
    ) {
    }

    /**
     * @param iterable<mixed> $source
     * @throws MappingError
     */
    public static function fromSource(iterable $source): self
    {
        return (new MapperBuilder())
            ->allowSuperfluousKeys()
            ->allowPermissiveTypes()
            ->mapper()
            ->map(self::class, $source)
        ;
    }

    public function schemaName(string $ref, string $where): string
    {
        $name = str_starts_with($ref, self::SCHEMA_REF)
            ? substr($ref, \strlen(self::SCHEMA_REF))
            : throw new GeneratorException("{$where}: unsupported \$ref `{$ref}`");
        if (!isset($this->components['schemas'][$name])) {
            throw new GeneratorException("{$where}: \$ref to missing schema `{$name}`");
        }

        return $name;
    }

    public function schema(string $name): Schema
    {
        return $this->components['schemas'][$name];
    }

    /**
     * @return Generator<string, Schema> 2xx JSON response bodies, keyed by where they are.
     */
    public function responseBodies(): Generator
    {
        foreach ($this->operations() as $where => $operation) {
            foreach ($operation->responses as $status => $response) {
                $schema = $response->content[self::JSON]->schema ?? null;
                if ($schema && str_starts_with((string) $status, '2')) {
                    yield "{$where} {$status}" => $schema;
                }
            }
        }
    }

    /**
     * @return Generator<string, Schema> JSON request bodies, keyed by where they are.
     */
    public function requestBodies(): Generator
    {
        foreach ($this->operations() as $where => $operation) {
            $schema = $operation->requestBody?->content[self::JSON]->schema ?? null;
            if ($schema) {
                yield "{$where} requestBody" => $schema;
            }
        }
    }

    /**
     * @return Generator<string, Operation>
     */
    private function operations(): Generator
    {
        foreach ($this->paths as $path => $operations) {
            foreach ($operations as $method => $operation) {
                yield "{$method} {$path}" => $operation;
            }
        }
    }
}
