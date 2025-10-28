<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/database',
        __DIR__ . '/modules',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0)
//    ->withImportNames()
    ->withPreparedSets(
        privatization: true,
//        earlyReturn: true,
//        strictBooleans: true,
    )
    ->withSets([
        RectorLaravel\Set\LaravelLevelSetList::UP_TO_LARAVEL_120,
        RectorLaravel\Set\LaravelSetList::LARAVEL_120,
        RectorLaravel\Set\LaravelSetList::LARAVEL_COLLECTION,
        RectorLaravel\Set\LaravelSetList::LARAVEL_CODE_QUALITY,
    ])
    ->withRules([
        //        EloquentMagicMethodToQueryBuilderRector::class,
        RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class,
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class,
        RectorLaravel\Rector\If_\AbortIfRector::class,
        RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector::class,
        RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class,
        RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector::class,
    ]);
