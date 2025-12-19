import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
export const health = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: health.url(options),
    method: 'get',
})

health.definition = {
    methods: ["get","head"],
    url: '/health',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
health.url = (options?: RouteQueryOptions) => {
    return health.definition.url + queryParams(options)
}

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
health.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: health.url(options),
    method: 'get',
})

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckResultsController.php:16
* @route '/health'
*/
health.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: health.url(options),
    method: 'head',
})

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckJsonResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckJsonResultsController.php:13
* @route '/health-json'
*/
export const healthJson = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: healthJson.url(options),
    method: 'get',
})

healthJson.definition = {
    methods: ["get","head"],
    url: '/health-json',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckJsonResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckJsonResultsController.php:13
* @route '/health-json'
*/
healthJson.url = (options?: RouteQueryOptions) => {
    return healthJson.definition.url + queryParams(options)
}

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckJsonResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckJsonResultsController.php:13
* @route '/health-json'
*/
healthJson.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: healthJson.url(options),
    method: 'get',
})

/**
* @see \Spatie\Health\Http\Controllers\HealthCheckJsonResultsController::__invoke
* @see vendor/spatie/laravel-health/src/Http/Controllers/HealthCheckJsonResultsController.php:13
* @route '/health-json'
*/
healthJson.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: healthJson.url(options),
    method: 'head',
})

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
export const healthCustom = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: healthCustom.url(options),
    method: 'get',
})

healthCustom.definition = {
    methods: ["get","head"],
    url: '/health-custom',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
healthCustom.url = (options?: RouteQueryOptions) => {
    return healthCustom.definition.url + queryParams(options)
}

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
healthCustom.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: healthCustom.url(options),
    method: 'get',
})

/**
* @see \Modules\Monitoring\Http\Controllers\HealthCheckController::__invoke
* @see modules/monitoring/src/Http/Controllers/HealthCheckController.php:27
* @route '/health-custom'
*/
healthCustom.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: healthCustom.url(options),
    method: 'head',
})

const monitoring = {
    health: Object.assign(health, health),
    healthJson: Object.assign(healthJson, healthJson),
    healthCustom: Object.assign(healthCustom, healthCustom),
}

export default monitoring