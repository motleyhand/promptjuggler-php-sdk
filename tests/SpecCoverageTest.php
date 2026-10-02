<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests;

use CuyZ\Valinor\Mapper\Source\Source;
use PHPUnit\Framework\Attributes\DataProvider;
use PromptJuggler\Client\Exception\DecodeException;
use PromptJuggler\Client\PromptJuggler;
use PromptJuggler\Client\Tools\ModelGenerator;
use PromptJuggler\Client\Tools\OpenApi\Operation;
use PromptJuggler\Client\Tools\OpenApi\Spec;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use SplFileObject;

/**
 * Keeps the hand-written facade in step with the spec the models are generated from.
 */
final class SpecCoverageTest extends SdkTestCase
{
    private const METHODS = [
        'get_prompt_revision' => 'getPrompt',
        'create_prompt_run' => 'runPrompt',
        'get_prompt_run' => 'getPromptRun',
        'create_workflow_run' => 'runWorkflow',
        'get_workflow_run' => 'getWorkflowRun',
        'create_stream_token' => 'createStreamToken',
        'public_get_knowledge_base' => 'getKnowledgeBase',
        'public_get_document' => 'getKnowledgeDocument',
        'public_delete_document' => 'deleteKnowledgeDocument',
        'public_upload_documents' => 'uploadDocuments',
    ];

    private const SAMPLES = [
        'slug' => 'my-slug',
        'version' => 3,
        'id' => 'my-id',
        'thread' => 'my-thread',
        'inputs' => [],
        'files' => ['a.txt' => 'A'],
    ];

    public function testEveryOperationHasAFacadeMethod(): void
    {
        self::assertEqualsCanonicalizing(
            array_keys(self::METHODS),
            array_map(static fn (array $case): ?string => $case[2]->operationId, array_values([...self::operations()])),
        );
    }

    #[DataProvider('operations')]
    public function testFacadeSendsTheOperationsMethodAndPath(
        string $httpMethod,
        string $path,
        Operation $operation,
    ): void {
        $method = self::facadeMethod($operation);
        $pathParams = self::pathParams($path);
        $required = array_map(
            static fn (ReflectionParameter $parameter): string => $parameter->getName(),
            array_filter($method->getParameters(), static fn (ReflectionParameter $p): bool => !$p->isOptional()),
        );
        $pj = $this->client('sk-test', [self::rawJsonResponse('{}')]);

        try {
            $method->invokeArgs($pj, array_combine(
                $required,
                array_map(static fn (string $name): mixed => self::SAMPLES[$name], $required),
            ));
        } catch (DecodeException) {
            // `{}` is no valid response body for most operations; only the request matters here.
        }

        $request = $this->lastRequest();
        self::assertSame($httpMethod, $request->getMethod());
        self::assertSame(
            strtr($path, array_combine(
                array_map(static fn (string $name): string => "{{$name}}", $pathParams),
                array_map(static fn (string $name): string => (string) self::SAMPLES[$name], $pathParams),
            )),
            $request->getUri()->getPath(),
        );
    }

    #[DataProvider('operations')]
    public function testFacadeReturnsTheOperationsSuccessResponse(
        string $httpMethod,
        string $path,
        Operation $operation,
    ): void {
        $method = self::facadeMethod($operation);
        $returnType = $method->getReturnType();
        self::assertInstanceOf(ReflectionNamedType::class, $returnType);
        $docType = preg_match('/@return\s+(\S+)/', $method->getDocComment() ?: '', $match) ? $match[1] : null;

        self::assertSame(
            self::successType($path, $operation),
            $docType ?? str_replace(ModelGenerator::MODELS . '\\', '', $returnType->getName()),
        );
    }

    #[DataProvider('operationsWithABody')]
    public function testRequestBodyPropertiesMatchTheParameters(string $path, Operation $operation): void
    {
        $spec = self::spec();
        $parameters = array_map(
            static fn (ReflectionParameter $parameter): string => $parameter->getName(),
            self::facadeMethod($operation)->getParameters(),
        );

        foreach ($operation->requestBody->content ?? [] as $mediaType => $content) {
            $schema = $content->schema;
            self::assertNotNull($schema);
            $properties = $schema->ref
                ? $spec->schema($spec->schemaName($schema->ref, $path))->properties
                : $schema->properties;
            self::assertEqualsCanonicalizing(
                array_keys($properties),
                array_values(array_diff($parameters, self::pathParams($path))),
                "{$mediaType} body of {$operation->operationId}",
            );
        }
    }

    /**
     * @return iterable<string, array{string, string, Operation}>
     */
    public static function operations(): iterable
    {
        foreach (self::spec()->paths as $path => $operations) {
            foreach ($operations as $method => $operation) {
                yield "{$method} {$path}" => [strtoupper($method), $path, $operation];
            }
        }
    }

    /**
     * @return iterable<string, array{string, Operation}>
     */
    public static function operationsWithABody(): iterable
    {
        foreach (self::operations() as $name => [, $path, $operation]) {
            if ($operation->requestBody) {
                yield $name => [$path, $operation];
            }
        }
    }

    private static function spec(): Spec
    {
        return Spec::fromSource(Source::file(new SplFileObject(\dirname(__DIR__, 3) . '/docs/openapi.json')));
    }

    /**
     * The 2xx response's type as a PHPDoc would name it.
     */
    private static function successType(string $path, Operation $operation): string
    {
        $successes = array_filter(
            $operation->responses,
            static fn (int|string $status): bool => str_starts_with((string) $status, '2'),
            ARRAY_FILTER_USE_KEY,
        );
        self::assertCount(1, $successes);
        $schema = array_values($successes)[0]->content['application/json']->schema ?? null;
        $spec = self::spec();

        return match (true) {
            $schema === null => 'void',
            $schema->ref !== null => $spec->schemaName($schema->ref, $path),
            $schema->items?->ref !== null => 'list<' . $spec->schemaName($schema->items->ref, $path) . '>',
            default => self::fail("{$path}: no type for its success response"),
        };
    }

    private static function facadeMethod(Operation $operation): ReflectionMethod
    {
        return new ReflectionMethod(PromptJuggler::class, self::METHODS[$operation->operationId ?? '']);
    }

    /**
     * @return list<string>
     */
    private static function pathParams(string $path): array
    {
        preg_match_all('/\{(\w+)\}/', $path, $matches);

        return $matches[1];
    }
}
