<?php

declare(strict_types=1);

// Style for the hand-written facade and tests only. The generated src/ is left
// exactly as Kiota emits it.
$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/lib', __DIR__ . '/tests']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'declare_strict_types' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays', 'arguments', 'parameters']],
    ])
    ->setFinder($finder);
