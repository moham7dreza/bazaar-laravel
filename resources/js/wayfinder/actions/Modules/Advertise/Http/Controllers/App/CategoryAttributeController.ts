import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryAttributeController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryAttributeController.php:18
* @route '/api/advertisements/category/{category}/attributes'
*/
const CategoryAttributeController = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CategoryAttributeController.url(args, options),
    method: 'get',
})

CategoryAttributeController.definition = {
    methods: ["get","head"],
    url: '/api/advertisements/category/{category}/attributes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryAttributeController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryAttributeController.php:18
* @route '/api/advertisements/category/{category}/attributes'
*/
CategoryAttributeController.url = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category: typeof args.category === 'object'
        ? args.category.id
        : args.category,
    }

    return CategoryAttributeController.definition.url
            .replace('{category}', parsedArgs.category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryAttributeController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryAttributeController.php:18
* @route '/api/advertisements/category/{category}/attributes'
*/
CategoryAttributeController.get = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CategoryAttributeController.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryAttributeController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryAttributeController.php:18
* @route '/api/advertisements/category/{category}/attributes'
*/
CategoryAttributeController.head = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CategoryAttributeController.url(args, options),
    method: 'head',
})

export default CategoryAttributeController