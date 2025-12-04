import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryController::index
* @see modules/advertise/src/Http/Controllers/App/CategoryController.php:19
* @route '/api/categories'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/categories',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryController::index
* @see modules/advertise/src/Http/Controllers/App/CategoryController.php:19
* @route '/api/categories'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryController::index
* @see modules/advertise/src/Http/Controllers/App/CategoryController.php:19
* @route '/api/categories'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryController::index
* @see modules/advertise/src/Http/Controllers/App/CategoryController.php:19
* @route '/api/categories'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const CategoryController = { index }

export default CategoryController