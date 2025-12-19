import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/suppressions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const suppressions = {
    index: Object.assign(index, index),
}

export default suppressions