import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\App\Home\CityController::index
* @see app/Http/Controllers/App/Home/CityController.php:19
* @route '/api/cities'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/cities',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\App\Home\CityController::index
* @see app/Http/Controllers/App/Home/CityController.php:19
* @route '/api/cities'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\App\Home\CityController::index
* @see app/Http/Controllers/App/Home/CityController.php:19
* @route '/api/cities'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\App\Home\CityController::index
* @see app/Http/Controllers/App/Home/CityController.php:19
* @route '/api/cities'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const cities = {
    index: Object.assign(index, index),
}

export default cities