import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:31
* @route '/api/advertisements'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/advertisements',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:31
* @route '/api/advertisements'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:31
* @route '/api/advertisements'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:31
* @route '/api/advertisements'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::queryBuilder
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:84
* @route '/api/advertisements/query-builder'
*/
export const queryBuilder = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: queryBuilder.url(options),
    method: 'get',
})

queryBuilder.definition = {
    methods: ["get","head"],
    url: '/api/advertisements/query-builder',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::queryBuilder
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:84
* @route '/api/advertisements/query-builder'
*/
queryBuilder.url = (options?: RouteQueryOptions) => {
    return queryBuilder.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::queryBuilder
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:84
* @route '/api/advertisements/query-builder'
*/
queryBuilder.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: queryBuilder.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::queryBuilder
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:84
* @route '/api/advertisements/query-builder'
*/
queryBuilder.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: queryBuilder.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:46
* @route '/api/advertisements/{advertisement}'
*/
export const show = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/advertisements/{advertisement}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:46
* @route '/api/advertisements/{advertisement}'
*/
show.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { advertisement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { advertisement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
    }

    return show.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:46
* @route '/api/advertisements/{advertisement}'
*/
show.get = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/App/AdvertisementController.php:46
* @route '/api/advertisements/{advertisement}'
*/
show.head = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const AdvertisementController = { index, queryBuilder, show }

export default AdvertisementController