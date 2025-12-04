import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
export const defaultMethod = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: defaultMethod.url(options),
    method: 'get',
})

defaultMethod.definition = {
    methods: ["get","head"],
    url: '/metrics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
defaultMethod.url = (options?: RouteQueryOptions) => {
    return defaultMethod.definition.url + queryParams(options)
}

/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
defaultMethod.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: defaultMethod.url(options),
    method: 'get',
})

/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
defaultMethod.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: defaultMethod.url(options),
    method: 'head',
})

const prometheus = {
    default: Object.assign(defaultMethod, defaultMethod),
}

export default prometheus