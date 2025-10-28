<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/.php-cs-fixer.dist.php',
        __DIR__.'/rector.php',
    ])
    ->withRules([
        Rector\TypeDeclaration\Rector\StmtsAwareInterface\DeclareStrictTypesRector::class,
    ])
    ->withSets([
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        LevelSetList::UP_TO_PHP_84,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
        SetList::PRIVATIZATION,
        SetList::STRICT_BOOLEANS,
        SetList::TYPE_DECLARATION,
        SymfonySetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::SYMFONY_64,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ])
    ->withSkip([
        __DIR__.'/src/Kernel.php',
        __DIR__.'/tests/bootstrap.php',
        Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector::class,
        Rector\CodeQuality\Rector\Concat\JoinStringConcatRector::class,
        Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector::class,
        Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector::class,
        Rector\CodingStyle\Rector\FunctionLike\FunctionLikeToFirstClassCallableRector::class,
        Rector\DeadCode\Rector\Cast\RecastingRemovalRector::class,
        Rector\Php70\Rector\FuncCall\RandomFunctionRector::class,
    ])
;
