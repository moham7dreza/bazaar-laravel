<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Set\LaravelLevelSetList;
use RectorLaravel\Set\LaravelSetList;

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
        LaravelLevelSetList::UP_TO_LARAVEL_120,
        LaravelSetList::LARAVEL_120,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_CODE_QUALITY,
    ])
    ->withRules([
        //        EloquentMagicMethodToQueryBuilderRector::class,
        EloquentOrderByToLatestOrOldestRector::class,
        RemoveDumpDataDeadCodeRector::class,
        RectorLaravel\Rector\If_\AbortIfRector::class,
        RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector::class,
        RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class,
        RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector::class,
    ]);
