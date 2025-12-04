import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::styling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
export const styling = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: styling.url(options),
    method: 'get',
})

styling.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/event-types-styling',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::styling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
styling.url = (options?: RouteQueryOptions) => {
    return styling.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::styling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
styling.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: styling.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::styling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
styling.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: styling.url(options),
    method: 'head',
})

const eventTypes = {
    styling: Object.assign(styling, styling),
}

export default eventTypes