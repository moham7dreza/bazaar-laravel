import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/api/images/store'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/images/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/api/images/store'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/api/images/store'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ImageController::destroy
* @see app/Http/Controllers/ImageController.php:32
* @route '/api/images/update'
*/
export const destroy = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: destroy.url(options),
    method: 'put',
})

destroy.definition = {
    methods: ["put"],
    url: '/api/images/update',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\ImageController::destroy
* @see app/Http/Controllers/ImageController.php:32
* @route '/api/images/update'
*/
destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::destroy
* @see app/Http/Controllers/ImageController.php:32
* @route '/api/images/update'
*/
destroy.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: destroy.url(options),
    method: 'put',
})

const images = {
    store: Object.assign(store, store),
    destroy: Object.assign(destroy, destroy),
}

export default images