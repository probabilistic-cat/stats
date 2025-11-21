<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/templates',
        __DIR__ . '/tests',
        __DIR__ . '/.php-cs-fixer.dist.php',
        __DIR__ . '/rector.php',
    ])
    ->withRules([
        Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector::class,
    ])
    ->withSets([
        LevelSetList::UP_TO_PHP_84,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
        SetList::PRIVATIZATION,
        SetList::STRICT_BOOLEANS,
        SetList::TYPE_DECLARATION,
    ])
    ->withComposerBased(twig: true, symfony: true)
    ->withSkip([
        __DIR__ . '/src/Kernel.php',
        __DIR__ . '/tests/bootstrap.php',
        Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector::class,
        Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector::class,
        Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector::class,
    ])
;
