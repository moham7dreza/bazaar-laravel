import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::show
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/analytics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::show
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::show
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::show
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

const RequestAnalyticsController = { show }

export default RequestAnalyticsController