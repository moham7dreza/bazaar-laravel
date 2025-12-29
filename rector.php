<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Enum_\EnumCaseToPascalCaseRector;
use Rector\Config\RectorConfig;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector;
use RectorLaravel\Rector\Class_\UseForwardsCallsTraitRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\ConfigToTypedConfigMethodCallRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector;
use RectorLaravel\Rector\MethodCall\UseComponentPropertyWithinCommandsRector;
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelSetProvider;
use RectorLaravel\Set\Packages\Faker\FakerSetList;
use RectorPest\Set\PestLevelSetList;
use RectorPest\Set\PestSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        __DIR__ . '/database',
        __DIR__ . '/modules',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withAttributesSets()
    ->withTypeCoverageLevel(10)
    ->withDeadCodeLevel(10)
    ->withCodeQualityLevel(10)
    ->withCodingStyleLevel(10)
    ->withImportNames(removeUnusedImports: true)
    ->withPreparedSets(
        privatization: true,
        earlyReturn: true,
    )
    ->withComposerBased(
        phpunit: true,
        laravel: true,
    )
    ->withRootFiles()
    ->withMemoryLimit('2G')
    ->withFluentCallNewLine()
    ->withParallel(maxNumberOfProcess: 10)
    ->withRealPathReporting()
    ->withSetProviders(LaravelSetProvider::class)
    ->withSets([
        LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_TESTING,
        LaravelSetList::LARAVEL_TYPE_DECLARATIONS,
        FakerSetList::FAKER_10,
        // \RectorLaravel\Set\Packages\Livewire\LivewireSetList::LIVEWIRE_30,
        PestLevelSetList::UP_TO_PEST_40,
        PestSetList::PEST_CODE_QUALITY,
    ])
    ->withRules([
        RemoveDumpDataDeadCodeRector::class,
        ResponseHelperCallToJsonResponseRector::class,
        ArrayToArrGetRector::class,
        ConfigToTypedConfigMethodCallRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        // RectorLaravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class,
        RemoveModelPropertyFromFactoriesRector::class,
        RouteActionCallableRector::class,
        UseComponentPropertyWithinCommandsRector::class,
        UseForwardsCallsTraitRector::class,
        WhereToWhereLikeRector::class,
        EnumCaseToPascalCaseRector::class,
    ]);
