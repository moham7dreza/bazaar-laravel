import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
export const heatmap = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: heatmap.url(options),
    method: 'get',
})

heatmap.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/analytics/heatmap',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
heatmap.url = (options?: RouteQueryOptions) => {
    return heatmap.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
heatmap.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: heatmap.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
heatmap.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: heatmap.url(options),
    method: 'head',
})

const analytics = {
    heatmap: Object.assign(heatmap, heatmap),
}

export default analytics