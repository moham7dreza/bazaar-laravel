<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\Enum_\EnumCaseToPascalCaseRector;
use Rector\Config\RectorConfig;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Class_\LivewireComponentComputedMethodToComputedAttributeRector;
use RectorLaravel\Rector\Class_\LivewireComponentQueryStringToUrlAttributeRector;
use RectorLaravel\Rector\Class_\RemoveModelPropertyFromFactoriesRector;
use RectorLaravel\Rector\Class_\UseForwardsCallsTraitRector;
use RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use RectorLaravel\Rector\FuncCall\ConfigToTypedConfigMethodCallRector;
use RectorLaravel\Rector\FuncCall\FactoryFuncCallToStaticCallRector;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\MethodCall\EloquentOrderByToLatestOrOldestRector;
use RectorLaravel\Rector\MethodCall\ReplaceServiceContainerCallArgRector;
use RectorLaravel\Rector\MethodCall\ResponseHelperCallToJsonResponseRector;
use RectorLaravel\Rector\MethodCall\UseComponentPropertyWithinCommandsRector;
use RectorLaravel\Rector\MethodCall\WhereToWhereLikeRector;
use RectorLaravel\Rector\Namespace_\FactoryDefinitionRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\PropertyFetch\ReplaceFakerPropertyFetchWithMethodCallRector;
use RectorLaravel\Rector\StaticCall\EloquentMagicMethodToQueryBuilderRector;
use RectorLaravel\Rector\StaticCall\RouteActionCallableRector;
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
    ->withPhpSets()
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0)
    ->withImportNames(removeUnusedImports: true)
    ->withPreparedSets(
        privatization: true,
        earlyReturn: true,
    )
    ->withComposerBased(
        phpunit: true,
        laravel: true,
    )
    ->withCodingStyleLevel(0)
    ->withRootFiles()
    ->withSets([
        LaravelLevelSetList::UP_TO_LARAVEL_120,
        LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_120,
        LaravelSetList::LARAVEL_ARRAYACCESS_TO_METHOD_CALL,
        LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_COLLECTION,
        LaravelSetList::LARAVEL_CONTAINER_STRING_TO_FULLY_QUALIFIED_NAME,
        LaravelSetList::LARAVEL_ELOQUENT_MAGIC_METHOD_TO_QUERY_BUILDER,
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        LaravelSetList::LARAVEL_FACTORIES,
        LaravelSetList::LARAVEL_IF_HELPERS,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
        //                RectorLaravel\Set\LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        LaravelSetList::LARAVEL_TESTING,
        LaravelSetList::LARAVEL_TYPE_DECLARATIONS,
    ])
    ->withRules([
        EloquentMagicMethodToQueryBuilderRector::class,
        EloquentOrderByToLatestOrOldestRector::class,
        RemoveDumpDataDeadCodeRector::class,
        AddArgumentDefaultValueRector::class,
        ResponseHelperCallToJsonResponseRector::class,
        ArgumentFuncCallToMethodCallRector::class,
        ArrayToArrGetRector::class,
        ConfigToTypedConfigMethodCallRector::class,
        EmptyToBlankAndFilledFuncRector::class,
        FactoryDefinitionRector::class,
        FactoryFuncCallToStaticCallRector::class,
        //        RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector::class,
        LivewireComponentComputedMethodToComputedAttributeRector::class,
        LivewireComponentQueryStringToUrlAttributeRector::class,
        OptionalToNullsafeOperatorRector::class,
        //        RectorLaravel\Rector\StaticCall\MinutesToSecondsInCacheRector::class,
        RemoveModelPropertyFromFactoriesRector::class,
        ReplaceFakerPropertyFetchWithMethodCallRector::class,
        ReplaceServiceContainerCallArgRector::class,
        //        RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector::class,
        RouteActionCallableRector::class,
        UseComponentPropertyWithinCommandsRector::class,
        UseForwardsCallsTraitRector::class,
        WhereToWhereLikeRector::class,
        EnumCaseToPascalCaseRector::class,
    ]);
