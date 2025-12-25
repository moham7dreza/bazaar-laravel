import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\ImageController::index
* @see app/Http/Controllers/ImageController.php:15
* @route '/image'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/image',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ImageController::index
* @see app/Http/Controllers/ImageController.php:15
* @route '/image'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::index
* @see app/Http/Controllers/ImageController.php:15
* @route '/image'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ImageController::index
* @see app/Http/Controllers/ImageController.php:15
* @route '/image'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/image/store'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/image/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/image/store'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/image/store'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const image = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
}

export default image