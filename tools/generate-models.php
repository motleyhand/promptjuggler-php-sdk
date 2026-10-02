<?php

declare(strict_types=1);

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Exception\InvalidSource;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\Tree\Message\NodeMessage;
use PromptJuggler\Client\Tools\GeneratorException;
use PromptJuggler\Client\Tools\ModelGenerator;
use PromptJuggler\Client\Tools\OpenApi\Spec;

require __DIR__ . '/../vendor/autoload.php';

$fail = static function (string $message): never {
    fwrite(STDERR, "{$message}\n");
    exit(1);
};

if (!isset($argv) || \count($argv) !== 3) {
    $fail('Usage: php tools/generate-models.php <spec.json> <out-dir>');
}
[, $specPath, $outDir] = $argv;
if (is_dir($outDir) && (new FilesystemIterator($outDir))->valid()) {
    $fail("{$outDir} is not empty.");
}
$json = file_get_contents($specPath);
if ($json === false) {
    $fail("Can't read {$specPath}.");
}

try {
    $files = (new ModelGenerator(Spec::fromSource(Source::json($json))))->generate();
} catch (MappingError $e) {
    $fail(implode("\n", array_map(
        static fn (NodeMessage $message): string => "{$message->path()}: {$message->toString()}",
        $e->messages()->toArray(),
    )));
} catch (InvalidSource|GeneratorException $e) {
    $fail($e->getMessage());
}

foreach ($files as $path => $source) {
    $target = "{$outDir}/{$path}";
    $dir = \dirname($target);
    if ((!is_dir($dir) && !mkdir($dir, 0o777, true)) || file_put_contents($target, $source) === false) {
        $fail("Can't write {$target}.");
    }
}
