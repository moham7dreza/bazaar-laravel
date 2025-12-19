import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
const HealthCheckResultsController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HealthCheckResultsController.url(options),
    method: 'get',
})

HealthCheckResultsController.definition = {
    methods: ["get","head"],
    url: '/health',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
HealthCheckResultsController.url = (options?: RouteQueryOptions) => {
    return HealthCheckResultsController.definition.url + queryParams(options)
}

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
HealthCheckResultsController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HealthCheckResultsController.url(options),
    method: 'get',
})

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
HealthCheckResultsController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: HealthCheckResultsController.url(options),
    method: 'head',
})

export default HealthCheckResultsController