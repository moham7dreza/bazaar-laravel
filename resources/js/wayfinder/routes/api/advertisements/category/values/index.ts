import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryValueController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryValueController.php:18
* @route '/api/advertisements/category/{categoryAttribute}/values'
*/
export const index = (args: { categoryAttribute: number | { id: number } } | [categoryAttribute: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/advertisements/category/{categoryAttribute}/values',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryValueController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryValueController.php:18
* @route '/api/advertisements/category/{categoryAttribute}/values'
*/
index.url = (args: { categoryAttribute: number | { id: number } } | [categoryAttribute: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { categoryAttribute: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { categoryAttribute: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            categoryAttribute: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        categoryAttribute: typeof args.categoryAttribute === 'object'
        ? args.categoryAttribute.id
        : args.categoryAttribute,
    }

    return index.definition.url
            .replace('{categoryAttribute}', parsedArgs.categoryAttribute.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryValueController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryValueController.php:18
* @route '/api/advertisements/category/{categoryAttribute}/values'
*/
index.get = (args: { categoryAttribute: number | { id: number } } | [categoryAttribute: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\CategoryValueController::__invoke
* @see modules/advertise/src/Http/Controllers/App/CategoryValueController.php:18
* @route '/api/advertisements/category/{categoryAttribute}/values'
*/
index.head = (args: { categoryAttribute: number | { id: number } } | [categoryAttribute: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

const values = {
    index: Object.assign(index, index),
}

export default values