import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Modules\Content\Http\Controllers\App\PageController::index
* @see modules/content/src/Http/Controllers/App/PageController.php:17
* @route '/api/pages'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/pages',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Content\Http\Controllers\App\PageController::index
* @see modules/content/src/Http/Controllers/App/PageController.php:17
* @route '/api/pages'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\App\PageController::index
* @see modules/content/src/Http/Controllers/App/PageController.php:17
* @route '/api/pages'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Content\Http\Controllers\App\PageController::index
* @see modules/content/src/Http/Controllers/App/PageController.php:17
* @route '/api/pages'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const pages = {
    index: Object.assign(index, index),
}

export default pages