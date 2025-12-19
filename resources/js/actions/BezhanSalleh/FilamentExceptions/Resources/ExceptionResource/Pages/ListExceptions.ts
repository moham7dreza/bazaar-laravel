import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ListExceptions::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ListExceptions.php:7
* @route '/super-admin/exceptions'
*/
const ListExceptions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListExceptions.url(options),
    method: 'get',
})

ListExceptions.definition = {
    methods: ["get","head"],
    url: '/super-admin/exceptions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ListExceptions::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ListExceptions.php:7
* @route '/super-admin/exceptions'
*/
ListExceptions.url = (options?: RouteQueryOptions) => {
    return ListExceptions.definition.url + queryParams(options)
}

/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ListExceptions::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ListExceptions.php:7
* @route '/super-admin/exceptions'
*/
ListExceptions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListExceptions.url(options),
    method: 'get',
})

/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ListExceptions::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ListExceptions.php:7
* @route '/super-admin/exceptions'
*/
ListExceptions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListExceptions.url(options),
    method: 'head',
})

export default ListExceptions