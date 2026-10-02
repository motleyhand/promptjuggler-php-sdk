<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests\Tools;

use CuyZ\Valinor\Mapper\MappingError;
use PHPUnit\Framework\TestCase;
use PromptJuggler\Client\Tools\GeneratorException;
use PromptJuggler\Client\Tools\ModelGenerator;
use PromptJuggler\Client\Tools\OpenApi\Spec;

final class ModelGeneratorTest extends TestCase
{
    public function testClassParametersFollowRequirednessNullabilityAndDefaults(): void
    {
        $files = self::generate(self::spec([
            'Thing' => [
                'description' => 'A thing.',
                'type' => 'object',
                'required' => ['id', 'note', 'tier'],
                'properties' => [
                    'count' => ['type' => 'integer', 'default' => 0],
                    'id' => ['type' => 'string', 'format' => 'uuid', 'description' => "Thing\n  ID."],
                    'note' => ['type' => ['string', 'null']],
                    'label' => ['type' => ['string', 'null'], 'default' => null],
                    'tags' => ['type' => 'array', 'items' => ['type' => 'string'], 'default' => []],
                    'strict' => ['type' => ['boolean', 'null'], 'default' => false],
                    'tier' => ['$ref' => '#/components/schemas/Tier'],
                    'createdAt' => ['type' => 'string', 'format' => 'date-time'],
                    'serviceTier' => [
                        'oneOf' => [['$ref' => '#/components/schemas/Tier'], ['type' => 'null']],
                        'default' => 'default',
                    ],
                    'outputs' => ['type' => 'object', 'additionalProperties' => ['type' => ['string', 'null']]],
                    'idOrTag' => ['oneOf' => [['type' => 'integer'], ['type' => 'string']]],
                ],
            ],
            'Tier' => ['type' => 'string', 'enum' => ['auto', 'default']],
        ], 'Thing', []));

        self::assertSame(<<<'PHP'
            <?php

            declare(strict_types=1);

            namespace PromptJuggler\Client\Models;

            use DateTimeImmutable;

            /**
             * A thing.
             */
            final readonly class Thing
            {
                /**
                 * @param string $id Thing ID.
                 * @param string|null $note
                 * @param Tier|UnknownEnumValue $tier
                 * @param int $count
                 * @param string|null $label
                 * @param list<string> $tags
                 * @param bool|null $strict
                 * @param DateTimeImmutable|null $createdAt
                 * @param Tier|UnknownEnumValue|null $serviceTier
                 * @param array<string, string|null>|null $outputs
                 * @param int|string|null $idOrTag
                 */
                public function __construct(
                    public string $id,
                    public ?string $note,
                    public Tier|UnknownEnumValue $tier,
                    public int $count = 0,
                    public ?string $label = null,
                    public array $tags = [],
                    public ?bool $strict = false,
                    public ?DateTimeImmutable $createdAt = null,
                    public Tier|UnknownEnumValue|null $serviceTier = Tier::Default,
                    public ?array $outputs = null,
                    public int|string|null $idOrTag = null,
                ) {
                }
            }

            PHP, $files['Models/Thing.php']);
    }

    public function testOnlyResponseReachableSchemasAndRequestBodyEnumsAreGenerated(): void
    {
        $priority = ['type' => 'string', 'default' => 'normal', 'enum' => ['onsite', 'normal', 'low']];
        $files = self::generate(self::spec([
            'Run' => [
                'type' => 'object',
                'required' => ['id', 'method'],
                'properties' => [
                    'id' => ['type' => 'string'],
                    'method' => ['type' => 'string', 'enum' => ['GET', 'POST']],
                ],
            ],
            'CreateRun' => [
                'type' => 'object',
                'properties' => [
                    'priority' => $priority,
                    'metadata' => [
                        'type' => 'object',
                        'additionalProperties' => [
                            'oneOf' => [['type' => 'string'], ['type' => 'array', 'items' => ['type' => 'string']]],
                        ],
                    ],
                ],
            ],
            'CreateBatch' => ['type' => 'object', 'properties' => ['priority' => $priority]],
            'ErrorResponse' => ['type' => 'object', 'properties' => ['error' => ['type' => 'string']]],
        ], 'Run', ['CreateRun', 'CreateBatch']));

        self::assertSame(
            [
                'Mapping/ModelMapping.php',
                'Models/Priority.php',
                'Models/Run.php',
                'Models/RunMethod.php',
                'Models/UnknownEnumValue.php',
            ],
            array_keys($files),
        );
        self::assertStringContainsString(<<<'PHP'
            enum Priority: string
            {
                case Onsite = 'onsite';
                case Normal = 'normal';
                case Low = 'low';
            }
            PHP, $files['Models/Priority.php']);
        self::assertStringContainsString('public RunMethod|UnknownEnumValue $method,', $files['Models/Run.php']);
        self::assertStringContainsString(<<<'PHP'
                        ->registerConverter(
                            static fn (string $value): RunMethod|UnknownEnumValue
                                => RunMethod::tryFrom($value) ?? new UnknownEnumValue($value),
                        )
            PHP, $files['Mapping/ModelMapping.php']);
        self::assertStringNotContainsString('Priority', $files['Mapping/ModelMapping.php']);
    }

    public function testEnumCaseNamesArePascalCaseWithUnderscoresBetweenDigitGroups(): void
    {
        $values = ['gpt-5.4-mini', 'claude-opus-4-5', 'gpt-4o-mini', 'read_only', 'GET'];
        $files = self::generate(self::spec(['Model' => ['type' => 'string', 'enum' => $values]], 'Model', []));

        self::assertStringContainsString(<<<'PHP'
            enum Model: string
            {
                case Gpt5_4Mini = 'gpt-5.4-mini';
                case ClaudeOpus4_5 = 'claude-opus-4-5';
                case Gpt4oMini = 'gpt-4o-mini';
                case ReadOnly = 'read_only';
                case Get = 'GET';
            }
            PHP, $files['Models/Model.php']);
    }

    public function testDiscriminatedUnionBecomesASealedInterfaceWithAnUnknownFallback(): void
    {
        $files = self::generate(self::spec([
            'Shape' => [
                'description' => 'A shape.',
                'type' => 'object',
                'required' => ['type'],
                'properties' => ['type' => ['type' => 'string']],
                'discriminator' => [
                    'propertyName' => 'type',
                    'mapping' => ['circle' => '#/components/schemas/Circle', 'square' => '#/components/schemas/Square'],
                ],
                'oneOf' => [['$ref' => '#/components/schemas/Circle'], ['$ref' => '#/components/schemas/Square']],
            ],
            'Circle' => [
                'type' => 'object',
                'required' => ['radius', 'type'],
                'properties' => [
                    'radius' => ['type' => 'number'],
                    'type' => ['type' => 'string', 'enum' => ['circle']],
                ],
            ],
            'Square' => [
                'type' => 'object',
                'required' => ['type'],
                'properties' => ['type' => ['type' => 'string', 'enum' => ['square']]],
            ],
        ], 'Shape', []));

        self::assertSame(
            [
                'Mapping/ModelMapping.php',
                'Models/Circle.php',
                'Models/Shape.php',
                'Models/Square.php',
                'Models/UnknownEnumValue.php',
                'Models/UnknownShape.php',
            ],
            array_keys($files),
            'Discriminator tags must not become enums.',
        );
        self::assertSame(<<<'PHP'
            <?php

            declare(strict_types=1);

            namespace PromptJuggler\Client\Models;

            /**
             * A shape.
             *
             * @phpstan-sealed Circle|Square|UnknownShape
             */
            interface Shape
            {
            }

            PHP, $files['Models/Shape.php']);
        self::assertStringContainsString(<<<'PHP'
            final readonly class Circle implements Shape
            {
                /**
                 * @param float $radius
                 * @param 'circle' $type
                 */
                public function __construct(
                    public float $radius,
                    public string $type,
                ) {
                }
            }
            PHP, $files['Models/Circle.php']);
        self::assertStringContainsString('public string $type,', $files['Models/Square.php']);
        self::assertStringContainsString(<<<'PHP'
            /**
             * A `Shape` whose `type` this SDK version doesn't know.
             */
            final readonly class UnknownShape implements Shape, JsonSerializable
            {
                /**
                 * @phpstan-pure
                 * @param array<string, mixed> $data The object as the API sent it, discriminator included.
                 */
                public function __construct(
                    public string $type,
                    public array $data,
                ) {
                }
            PHP, $files['Models/UnknownShape.php']);

        $mapping = $files['Mapping/ModelMapping.php'];
        self::assertStringContainsString("'circle' => Circle::class,", $mapping);
        self::assertStringContainsString(<<<'PHP'
                        ->registerConverter(self::shape(...))
                        ->infer(Shape::class, self::shapeClass(...))
            PHP, $mapping);
        self::assertStringContainsString('function shape(array $value, callable $next): Shape', $mapping);
        self::assertStringContainsString('@return class-string<Circle|Square>', $mapping);
        self::assertStringContainsString('function shapeClass(string $type): string', $mapping);
    }

    public function testFreeFormObjectBypassesTheEnumConverters(): void
    {
        $files = self::generate(self::spec([
            'Item' => [
                'type' => 'object',
                'required' => ['tool', 'payload'],
                'properties' => [
                    'tool' => ['type' => 'string'],
                    'payload' => ['type' => 'object', 'additionalProperties' => true],
                ],
            ],
        ], 'Item', []));

        self::assertStringContainsString('use PromptJuggler\Client\Mapping\RawJson;', $files['Models/Item.php']);
        self::assertStringContainsString('@param array<string, mixed> $payload', $files['Models/Item.php']);
        self::assertStringContainsString("#[RawJson]\n        public array \$payload,", $files['Models/Item.php']);
    }

    public function testRejectsAllOf(): void
    {
        $this->expectException(MappingError::class);
        $this->expectExceptionMessage('components.schemas.Thing.allOf');

        self::generate(self::spec(['Thing' => ['allOf' => [['type' => 'object']]]], 'Thing', []));
    }

    public function testRejectsASingleParameterClass(): void
    {
        $this->expectException(GeneratorException::class);
        $this->expectExceptionMessage('Wrapper: Valinor would map the whole object into its only property');

        $items = ['type' => 'array', 'items' => ['type' => 'string']];
        $wrapper = ['type' => 'object', 'properties' => ['items' => $items]];
        self::generate(self::spec(['Wrapper' => $wrapper], 'Wrapper', []));
    }

    public function testRejectsAnInlineObjectAsAResponseBody(): void
    {
        $spec = self::spec([], 'Missing', []);
        $spec['paths']['/thing']['get']['responses']['200']['content']['application/json']['schema'] = [
            'type' => 'array',
            'items' => ['type' => 'object', 'properties' => ['id' => ['type' => 'string']]],
        ];

        $this->expectException(GeneratorException::class);
        $this->expectExceptionMessage('get /thing 200.items: an object with properties needs a component schema');

        self::generate($spec);
    }

    public function testRejectsAFreeFormResponseBody(): void
    {
        $spec = self::spec([], 'Missing', []);
        $spec['paths']['/thing']['get']['responses']['200']['content']['application/json']['schema'] = [
            'type' => 'object',
            'additionalProperties' => true,
        ];

        $this->expectException(GeneratorException::class);
        $this->expectExceptionMessage("get /thing 200: a free-form object must be a property's own schema");

        self::generate($spec);
    }

    public function testRejectsEnumCaseCollisions(): void
    {
        $this->expectException(GeneratorException::class);
        $this->expectExceptionMessage('Memory: `read_only` and `read-only` both become case `ReadOnly`');

        $memory = ['type' => 'string', 'enum' => ['read_only', 'read-only']];
        self::generate(self::spec(['Memory' => $memory], 'Memory', []));
    }

    /**
     * A spec whose GET answers 200 with `$response` and 400 with an `ErrorResponse`, plus a POST per request body.
     *
     * @param array<string, array<string, mixed>> $schemas
     * @param list<string> $requestBodies
     * @return array<string, mixed>
     */
    private static function spec(array $schemas, string $response, array $requestBodies): array
    {
        $ref = static fn (string $name): array => ['schema' => ['$ref' => "#/components/schemas/{$name}"]];
        $paths = ['/thing' => ['get' => ['responses' => [
            '200' => ['description' => 'OK', 'content' => ['application/json' => $ref($response)]],
            '400' => ['description' => 'Bad', 'content' => ['application/json' => $ref('ErrorResponse')]],
        ]]]];
        foreach ($requestBodies as $name) {
            $paths["/{$name}"] = ['post' => [
                'requestBody' => ['required' => true, 'content' => ['application/json' => $ref($name)]],
                'responses' => ['204' => ['description' => 'Done']],
            ]];
        }

        return ['openapi' => '3.1.1', 'paths' => $paths, 'components' => ['schemas' => $schemas]];
    }

    /**
     * @param array<string, mixed> $spec
     * @return array<string, string>
     */
    private static function generate(array $spec): array
    {
        return (new ModelGenerator(Spec::fromSource($spec)))->generate();
    }
}
