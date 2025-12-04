import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import api from './api'
import exportMethod from './export'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::dashboard
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::dashboard
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::dashboard
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::dashboard
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

const activitylogUi = {
    dashboard: Object.assign(dashboard, dashboard),
    api: Object.assign(api, api),
    export: Object.assign(exportMethod, exportMethod),
}

export default activitylogUi