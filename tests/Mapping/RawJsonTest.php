<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tests\Mapping;

use CuyZ\Valinor\MapperBuilder;
use PHPUnit\Framework\TestCase;
use PromptJuggler\Client\Mapping\RawJson;

final class RawJsonTest extends TestCase
{
    public function testFreeFormPayloadBypassesGlobalConverters(): void
    {
        $payload = ['status' => 'pending', 'nested' => ['type' => 'http'], 'list' => ['pending', 1]];
        $mapper = (new MapperBuilder())
            ->allowPermissiveTypes()
            ->registerConverter(static fn (string $value): RawJsonStatus => RawJsonStatus::from($value))
            ->registerConverter(static fn (array $value): RawJsonShape => new RawJsonShape())
            ->mapper()
        ;

        self::assertSame($payload, $mapper->map(RawJsonItem::class, ['payload' => $payload, 'tool' => 'x'])->payload);
    }
}

final readonly class RawJsonItem
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public string $tool,
        #[RawJson]
        public array $payload,
    ) {
    }
}

enum RawJsonStatus: string
{
    case Pending = 'pending';
}

final class RawJsonShape
{
}
