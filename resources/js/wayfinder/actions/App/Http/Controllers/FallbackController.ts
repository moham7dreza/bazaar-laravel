import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\FallbackController::__invoke
* @see app/Http/Controllers/FallbackController.php:11
* @route '/{fallbackPlaceholder}'
*/
const FallbackController = (args: { fallbackPlaceholder: string | number } | [fallbackPlaceholder: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: FallbackController.url(args, options),
    method: 'get',
})

FallbackController.definition = {
    methods: ["get","head"],
    url: '/{fallbackPlaceholder}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\FallbackController::__invoke
* @see app/Http/Controllers/FallbackController.php:11
* @route '/{fallbackPlaceholder}'
*/
FallbackController.url = (args: { fallbackPlaceholder: string | number } | [fallbackPlaceholder: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { fallbackPlaceholder: args }
    }

    if (Array.isArray(args)) {
        args = {
            fallbackPlaceholder: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        fallbackPlaceholder: args.fallbackPlaceholder,
    }

    return FallbackController.definition.url
            .replace('{fallbackPlaceholder}', parsedArgs.fallbackPlaceholder.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FallbackController::__invoke
* @see app/Http/Controllers/FallbackController.php:11
* @route '/{fallbackPlaceholder}'
*/
FallbackController.get = (args: { fallbackPlaceholder: string | number } | [fallbackPlaceholder: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: FallbackController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\FallbackController::__invoke
* @see app/Http/Controllers/FallbackController.php:11
* @route '/{fallbackPlaceholder}'
*/
FallbackController.head = (args: { fallbackPlaceholder: string | number } | [fallbackPlaceholder: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: FallbackController.url(args, options),
    method: 'head',
})

export default FallbackController