import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:20
* @route '/api/panel/users/advertisements/history'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/panel/users/advertisements/history',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:20
* @route '/api/panel/users/advertisements/history'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:20
* @route '/api/panel/users/advertisements/history'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:20
* @route '/api/panel/users/advertisements/history'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::store
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:30
* @route '/api/panel/users/advertisements/history/{advertisement}'
*/
export const store = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/panel/users/advertisements/history/{advertisement}',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::store
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:30
* @route '/api/panel/users/advertisements/history/{advertisement}'
*/
store.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Panel\HistoryAdvertisementController::store
* @see modules/advertise/src/Http/Controllers/Panel/HistoryAdvertisementController.php:30
* @route '/api/panel/users/advertisements/history/{advertisement}'
*/
store.post = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

const history = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
}

export default history