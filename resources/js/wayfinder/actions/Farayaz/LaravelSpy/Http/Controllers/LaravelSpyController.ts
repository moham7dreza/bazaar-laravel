import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Farayaz\LaravelSpy\Http\Controllers\LaravelSpyController::index
* @see vendor/farayaz/laravel-spy/src/Http/Controllers/LaravelSpyController.php:12
* @route '/spy'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/spy',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Farayaz\LaravelSpy\Http\Controllers\LaravelSpyController::index
* @see vendor/farayaz/laravel-spy/src/Http/Controllers/LaravelSpyController.php:12
* @route '/spy'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Farayaz\LaravelSpy\Http\Controllers\LaravelSpyController::index
* @see vendor/farayaz/laravel-spy/src/Http/Controllers/LaravelSpyController.php:12
* @route '/spy'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Farayaz\LaravelSpy\Http\Controllers\LaravelSpyController::index
* @see vendor/farayaz/laravel-spy/src/Http/Controllers/LaravelSpyController.php:12
* @route '/spy'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const LaravelSpyController = { index }

export default LaravelSpyController