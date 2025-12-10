import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::overview
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:19
* @route '/api/v1/analytics/overview'
*/
export const overview = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: overview.url(options),
    method: 'get',
})

overview.definition = {
    methods: ["get","head"],
    url: '/api/v1/analytics/overview',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::overview
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:19
* @route '/api/v1/analytics/overview'
*/
overview.url = (options?: RouteQueryOptions) => {
    return overview.definition.url + queryParams(options)
}

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::overview
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:19
* @route '/api/v1/analytics/overview'
*/
overview.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: overview.url(options),
    method: 'get',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::overview
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:19
* @route '/api/v1/analytics/overview'
*/
overview.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: overview.url(options),
    method: 'head',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::visitors
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:32
* @route '/api/v1/analytics/visitors'
*/
export const visitors = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: visitors.url(options),
    method: 'get',
})

visitors.definition = {
    methods: ["get","head"],
    url: '/api/v1/analytics/visitors',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::visitors
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:32
* @route '/api/v1/analytics/visitors'
*/
visitors.url = (options?: RouteQueryOptions) => {
    return visitors.definition.url + queryParams(options)
}

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::visitors
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:32
* @route '/api/v1/analytics/visitors'
*/
visitors.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: visitors.url(options),
    method: 'get',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::visitors
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:32
* @route '/api/v1/analytics/visitors'
*/
visitors.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: visitors.url(options),
    method: 'head',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::pageViews
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:44
* @route '/api/v1/analytics/page-views'
*/
export const pageViews = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pageViews.url(options),
    method: 'get',
})

pageViews.definition = {
    methods: ["get","head"],
    url: '/api/v1/analytics/page-views',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::pageViews
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:44
* @route '/api/v1/analytics/page-views'
*/
pageViews.url = (options?: RouteQueryOptions) => {
    return pageViews.definition.url + queryParams(options)
}

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::pageViews
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:44
* @route '/api/v1/analytics/page-views'
*/
pageViews.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pageViews.url(options),
    method: 'get',
})

/**
* @see \MeShaon\RequestAnalytics\Http\Controllers\Api\AnalyticsApiController::pageViews
* @see vendor/me-shaon/laravel-request-analytics/src/Http/Controllers/Api/AnalyticsApiController.php:44
* @route '/api/v1/analytics/page-views'
*/
pageViews.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pageViews.url(options),
    method: 'head',
})

const AnalyticsApiController = { overview, visitors, pageViews }

export default AnalyticsApiController