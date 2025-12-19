import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::analytics
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
export const analytics = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: analytics.url(options),
    method: 'get',
})

analytics.definition = {
    methods: ["get","head"],
    url: '/analytics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::analytics
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
analytics.url = (options?: RouteQueryOptions) => {
    return analytics.definition.url + queryParams(options)
}

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::analytics
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
analytics.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: analytics.url(options),
    method: 'get',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\RequestAnalyticsController::analytics
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/RequestAnalyticsController.php:15
* @route '/analytics'
*/
analytics.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: analytics.url(options),
    method: 'head',
})

const request = {
    analytics: Object.assign(analytics, analytics),
}

export default request