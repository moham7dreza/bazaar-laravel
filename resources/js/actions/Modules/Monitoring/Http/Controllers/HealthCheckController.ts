import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
const HealthCheckController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HealthCheckController.url(options),
    method: 'get',
})

HealthCheckController.definition = {
    methods: ["get","head"],
    url: '/health-custom',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
HealthCheckController.url = (options?: RouteQueryOptions) => {
    return HealthCheckController.definition.url + queryParams(options)
}

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
HealthCheckController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: HealthCheckController.url(options),
    method: 'get',
})

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
HealthCheckController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: HealthCheckController.url(options),
    method: 'head',
})

export default HealthCheckController