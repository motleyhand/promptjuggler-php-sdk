<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools\OpenApi;

use CuyZ\Valinor\Mapper\Configurator\MapFromKey;
use Generator;

final readonly class Schema
{
    /**
     * @param string|list<string>|null $type
     * @param list<string>|null $enum
     * @param array<string, Schema> $properties
     * @param list<string> $required
     * @param list<Schema>|null $oneOf
     * @param null $allOf Unsupported, like the other keywords typed `null`: mapping rejects them.
     */
    public function __construct(
        #[MapFromKey('$ref')]
        public ?string $ref = null,
        public string|array|null $type = null,
        public ?string $format = null,
        public ?array $enum = null,
        public array $properties = [],
        public array $required = [],
        public ?Schema $items = null,
        public Schema|bool|null $additionalProperties = null,
        public ?array $oneOf = null,
        public ?Discriminator $discriminator = null,
        public ?string $description = null,
        public mixed $default = null,
        public null $allOf = null,
        public null $anyOf = null,
        public null $not = null,
        public null $const = null,
    ) {
    }

    /**
     * @return list<string>
     */
    public function types(): array
    {
        return \is_string($this->type) ? [$this->type] : $this->type ?? [];
    }

    public function isNull(): bool
    {
        return $this->types() === ['null'];
    }

    public function isScalar(): bool
    {
        return !$this->ref
            && $this->enum === null
            && $this->format !== 'date-time'
            && \in_array($this->type, ['string', 'integer', 'number', 'boolean'], true);
    }

    /**
     * @return Generator<string, Schema> The schemas nested directly in this one, keyed by their path from it.
     */
    public function children(): Generator
    {
        yield from $this->properties;
        if ($this->items) {
            yield 'items' => $this->items;
        }
        if ($this->additionalProperties instanceof self) {
            yield 'additionalProperties' => $this->additionalProperties;
        }
        foreach ($this->oneOf ?? [] as $i => $member) {
            yield "oneOf[{$i}]" => $member;
        }
    }
}
