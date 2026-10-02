<?php

declare(strict_types=1);

namespace PromptJuggler\Client\Tools;

/**
 * A string-backed enum. An open one is a response enum: it decodes values this SDK version doesn't know into
 * `UnknownEnumValue`.
 */
final readonly class StringEnum
{
    /**
     * @param list<string> $values
     */
    public function __construct(
        public string $name,
        public array $values,
        public bool $open,
        public ?string $description,
    ) {
    }

    /**
     * @return array<string, string> Case names, by value.
     */
    public function cases(): array
    {
        $cases = array_map($this->caseName(...), $this->values);
        $unique = array_unique($cases);
        $duplicates = array_diff_key($cases, $unique);
        if ($duplicates) {
            $i = array_key_first($duplicates);
            $first = $this->values[array_flip($unique)[$cases[$i]]];

            throw new GeneratorException(
                "{$this->name}: `{$first}` and `{$this->values[$i]}` both become case `{$cases[$i]}`",
            );
        }

        return array_combine($this->values, $cases);
    }

    /**
     * PascalCase of the alphanumeric runs, with `_` between two runs of digits: `gpt-5.4-mini` is `Gpt5_4Mini`.
     */
    private function caseName(string $value): string
    {
        $segments = preg_split('/[^A-Za-z0-9]+/', $value, -1, \PREG_SPLIT_NO_EMPTY) ?: [];
        $digits = array_map(static fn (string $segment): bool => preg_match('/^\d+$/', $segment) === 1, $segments);
        $name = implode('', array_map(
            static fn (int $i, string $segment): string => ($digits[$i] && ($digits[$i - 1] ?? false) ? '_' : '')
                . ucfirst(strtolower($segment)),
            array_keys($segments),
            $segments,
        ));
        if (!preg_match('/^[A-Za-z]/', $name) || strtolower($name) === 'class') {
            throw new GeneratorException("{$this->name}: `{$value}` can't become an enum case (`{$name}`)");
        }

        return $name;
    }
}
