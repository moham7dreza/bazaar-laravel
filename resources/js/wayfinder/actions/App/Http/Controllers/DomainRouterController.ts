import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
const DomainRouterController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DomainRouterController.url(options),
    method: 'get',
})

DomainRouterController.definition = {
    methods: ["get","head"],
    url: '/domain-router',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
DomainRouterController.url = (options?: RouteQueryOptions) => {
    return DomainRouterController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
DomainRouterController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DomainRouterController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
DomainRouterController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DomainRouterController.url(options),
    method: 'head',
})

export default DomainRouterController