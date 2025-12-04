import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Content\Http\Controllers\App\MenuController::index
* @see modules/content/src/Http/Controllers/App/MenuController.php:17
* @route '/api/menus'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/menus',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Content\Http\Controllers\App\MenuController::index
* @see modules/content/src/Http/Controllers/App/MenuController.php:17
* @route '/api/menus'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\App\MenuController::index
* @see modules/content/src/Http/Controllers/App/MenuController.php:17
* @route '/api/menus'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Content\Http\Controllers\App\MenuController::index
* @see modules/content/src/Http/Controllers/App/MenuController.php:17
* @route '/api/menus'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const MenuController = { index }

export default MenuController