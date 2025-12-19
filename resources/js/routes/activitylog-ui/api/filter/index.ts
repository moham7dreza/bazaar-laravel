import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::options
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
export const options = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: options.url(options),
    method: 'get',
})

options.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/filter-options',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::options
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
options.url = (options?: RouteQueryOptions) => {
    return options.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::options
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
options.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: options.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::options
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
options.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: options.url(options),
    method: 'head',
})

const filter = {
    options: Object.assign(options, options),
}

export default filter