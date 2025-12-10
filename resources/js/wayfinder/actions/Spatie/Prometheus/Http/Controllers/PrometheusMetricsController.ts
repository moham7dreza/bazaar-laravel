import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
const PrometheusMetricsController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PrometheusMetricsController.url(options),
    method: 'get',
})

PrometheusMetricsController.definition = {
    methods: ["get","head"],
    url: '/metrics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
PrometheusMetricsController.url = (options?: RouteQueryOptions) => {
    return PrometheusMetricsController.definition.url + queryParams(options)
}

/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
PrometheusMetricsController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PrometheusMetricsController.url(options),
    method: 'get',
})

/**
* @see \Spatie\Prometheus\Http\Controllers\PrometheusMetricsController::__invoke
* @see vendor/spatie/laravel-prometheus/src/Http/Controllers/PrometheusMetricsController.php:12
* @route '/metrics'
*/
PrometheusMetricsController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: PrometheusMetricsController.url(options),
    method: 'head',
})

export default PrometheusMetricsController