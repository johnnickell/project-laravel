<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/scripts',
        __DIR__.'/tests',
    ])
    ->withPhpSets(php85: true)
    // Receipt provider names are serialized evidence, not runtime class references.
    ->withSkip([
        StringClassNameToClassConstantRector::class => [__DIR__.'/tests/Feature/FrameworkSupportReceiptTest.php'],
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
