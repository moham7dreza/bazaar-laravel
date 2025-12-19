import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\App\StateController::index
* @see modules/advertise/src/Http/Controllers/App/StateController.php:19
* @route '/api/states'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/states',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\StateController::index
* @see modules/advertise/src/Http/Controllers/App/StateController.php:19
* @route '/api/states'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\StateController::index
* @see modules/advertise/src/Http/Controllers/App/StateController.php:19
* @route '/api/states'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\StateController::index
* @see modules/advertise/src/Http/Controllers/App/StateController.php:19
* @route '/api/states'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const states = {
    index: Object.assign(index, index),
}

export default states