<?php

declare(strict_types=1);

use Motley\EasyCodingStandard\SetList;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\CyclomaticComplexitySniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\ClassCommentSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withCache('.ecs-cache')
    ->withPaths([__DIR__ . '/lib', __DIR__ . '/src'])
    ->withRootFiles()
    ->withSets([SetList::MOTLEY])
    ->withSkip([ClassCommentSniff::class, CyclomaticComplexitySniff::class])
;
