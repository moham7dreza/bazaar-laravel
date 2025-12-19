import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
const ListSuppressions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSuppressions.url(options),
    method: 'get',
})

ListSuppressions.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/suppressions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
ListSuppressions.url = (options?: RouteQueryOptions) => {
    return ListSuppressions.definition.url + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
ListSuppressions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSuppressions.url(options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\SuppressionResource\Pages\ListSuppressions::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/SuppressionResource/Pages/ListSuppressions.php:7
* @route '/super-admin/mails/suppressions'
*/
ListSuppressions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSuppressions.url(options),
    method: 'head',
})

export default ListSuppressions