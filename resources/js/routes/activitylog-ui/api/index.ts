import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import activities from './activities'
import search from './search'
import filter from './filter'
import eventTypes from './event-types'
import analytics72d765 from './analytics'
import users from './users'
import views from './views'
import exportMethod9280c6 from './export'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
export const analytics = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: analytics.url(options),
    method: 'get',
})

analytics.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/analytics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
analytics.url = (options?: RouteQueryOptions) => {
    return analytics.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
analytics.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: analytics.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
analytics.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: analytics.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::exportMethod
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:27
* @route '/activitylog-ui/api/export'
*/
export const exportMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: exportMethod.url(options),
    method: 'post',
})

exportMethod.definition = {
    methods: ["post"],
    url: '/activitylog-ui/api/export',
} satisfies RouteDefinition<["post"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::exportMethod
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:27
* @route '/activitylog-ui/api/export'
*/
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::exportMethod
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:27
* @route '/activitylog-ui/api/export'
*/
exportMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: exportMethod.url(options),
    method: 'post',
})

const api = {
    activities: Object.assign(activities, activities),
    search: Object.assign(search, search),
    filter: Object.assign(filter, filter),
    eventTypes: Object.assign(eventTypes, eventTypes),
    analytics: Object.assign(analytics, analytics72d765),
    users: Object.assign(users, users),
    views: Object.assign(views, views),
    export: Object.assign(exportMethod, exportMethod9280c6),
}

export default api