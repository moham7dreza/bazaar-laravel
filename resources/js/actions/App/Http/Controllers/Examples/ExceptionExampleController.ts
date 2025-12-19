import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Examples\ExceptionExampleController::basicException
* @see app/Http/Controllers/Examples/ExceptionExampleController.php:28
* @route '/api/new-exception-sysyem'
*/
export const basicException = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: basicException.url(options),
    method: 'get',
})

basicException.definition = {
    methods: ["get","head"],
    url: '/api/new-exception-sysyem',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Examples\ExceptionExampleController::basicException
* @see app/Http/Controllers/Examples/ExceptionExampleController.php:28
* @route '/api/new-exception-sysyem'
*/
basicException.url = (options?: RouteQueryOptions) => {
    return basicException.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Examples\ExceptionExampleController::basicException
* @see app/Http/Controllers/Examples/ExceptionExampleController.php:28
* @route '/api/new-exception-sysyem'
*/
basicException.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: basicException.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Examples\ExceptionExampleController::basicException
* @see app/Http/Controllers/Examples/ExceptionExampleController.php:28
* @route '/api/new-exception-sysyem'
*/
basicException.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: basicException.url(options),
    method: 'head',
})

const ExceptionExampleController = { basicException }

export default ExceptionExampleController