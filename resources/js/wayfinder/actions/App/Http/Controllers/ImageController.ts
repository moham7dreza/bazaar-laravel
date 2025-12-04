import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/api/images/store'
*/
const storeefcc071ef6de060481b1fb01522d0d13 = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeefcc071ef6de060481b1fb01522d0d13.url(options),
    method: 'post',
})

storeefcc071ef6de060481b1fb01522d0d13.definition = {
    methods: ["post"],
    url: '/api/images/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/api/images/store'
*/
storeefcc071ef6de060481b1fb01522d0d13.url = (options?: RouteQueryOptions) => {
    return storeefcc071ef6de060481b1fb01522d0d13.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/api/images/store'
*/
storeefcc071ef6de060481b1fb01522d0d13.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeefcc071ef6de060481b1fb01522d0d13.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/image/store'
*/
const store870ac8b8e6a53bb2604a6af74982dedf = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store870ac8b8e6a53bb2604a6af74982dedf.url(options),
    method: 'post',
})

store870ac8b8e6a53bb2604a6af74982dedf.definition = {
    methods: ["post"],
    url: '/image/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/image/store'
*/
store870ac8b8e6a53bb2604a6af74982dedf.url = (options?: RouteQueryOptions) => {
    return store870ac8b8e6a53bb2604a6af74982dedf.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::store
* @see app/Http/Controllers/ImageController.php:20
* @route '/image/store'
*/
store870ac8b8e6a53bb2604a6af74982dedf.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store870ac8b8e6a53bb2604a6af74982dedf.url(options),
    method: 'post',
})

export const store = {
    '/api/images/store': storeefcc071ef6de060481b1fb01522d0d13,
    '/image/store': store870ac8b8e6a53bb2604a6af74982dedf,
}

/**
* @see \App\Http\Controllers\ImageController::update
* @see app/Http/Controllers/ImageController.php:32
* @route '/api/images/update'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/api/images/update',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\ImageController::update
* @see app/Http/Controllers/ImageController.php:32
* @route '/api/images/update'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ImageController::update
* @see app/Http/Controllers/ImageController.php:32
* @route '/api/images/update'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

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

const ImageController = { store, update, index }

export default ImageController