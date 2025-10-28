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
        RectorLaravel\Set\LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        RectorLaravel\Set\LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        RectorLaravel\Set\LaravelSetList::LARAVEL_CODE_QUALITY,
        RectorLaravel\Set\LaravelSetList::LARAVEL_COLLECTION,
        RectorLaravel\Set\LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        RectorLaravel\Set\LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        RectorLaravel\Set\LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        RectorLaravel\Set\LaravelSetList::LARAVEL_FACTORIES,
        RectorLaravel\Set\LaravelSetList::LARAVEL_IF_HELPERS,
        RectorLaravel\Set\LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        //                RectorLaravel\Set\LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        RectorLaravel\Set\LaravelSetList::LARAVEL_TESTING,
        //        RectorLaravel\Set\LaravelSetList::LARAVEL_TYPE_DECLARATIONS,
    ])
    ->withRules([
        //        EloquentMagicMethodToQueryBuilderRector::class,
        RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector::class,
        RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector::class,
        RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector::class,
        RectorLaravel\Rector\ClassMethod\AddGenericReturnTypeToRelationsRector::class,
        RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector::class,
    ]);
