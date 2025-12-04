import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::formats
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:172
* @route '/activitylog-ui/api/export/formats'
*/
export const formats = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: formats.url(options),
    method: 'get',
})

formats.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/export/formats',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::formats
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:172
* @route '/activitylog-ui/api/export/formats'
*/
formats.url = (options?: RouteQueryOptions) => {
    return formats.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::formats
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:172
* @route '/activitylog-ui/api/export/formats'
*/
formats.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: formats.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::formats
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:172
* @route '/activitylog-ui/api/export/formats'
*/
formats.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: formats.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::progress
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:152
* @route '/activitylog-ui/api/export/progress'
*/
export const progress = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: progress.url(options),
    method: 'get',
})

progress.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/export/progress',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::progress
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:152
* @route '/activitylog-ui/api/export/progress'
*/
progress.url = (options?: RouteQueryOptions) => {
    return progress.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::progress
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:152
* @route '/activitylog-ui/api/export/progress'
*/
progress.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: progress.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::progress
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:152
* @route '/activitylog-ui/api/export/progress'
*/
progress.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: progress.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::cleanup
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:201
* @route '/activitylog-ui/api/export/cleanup'
*/
export const cleanup = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: cleanup.url(options),
    method: 'post',
})

cleanup.definition = {
    methods: ["post"],
    url: '/activitylog-ui/api/export/cleanup',
} satisfies RouteDefinition<["post"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::cleanup
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:201
* @route '/activitylog-ui/api/export/cleanup'
*/
cleanup.url = (options?: RouteQueryOptions) => {
    return cleanup.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::cleanup
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:201
* @route '/activitylog-ui/api/export/cleanup'
*/
cleanup.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: cleanup.url(options),
    method: 'post',
})

const exportMethod = {
    formats: Object.assign(formats, formats),
    progress: Object.assign(progress, progress),
    cleanup: Object.assign(cleanup, cleanup),
}

export default exportMethod