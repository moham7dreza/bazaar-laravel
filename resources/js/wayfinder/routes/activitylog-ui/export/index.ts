import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::download
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:119
* @route '/activitylog-ui/export/download'
*/
export const download = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/export/download',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::download
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:119
* @route '/activitylog-ui/export/download'
*/
download.url = (options?: RouteQueryOptions) => {
    return download.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::download
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:119
* @route '/activitylog-ui/export/download'
*/
download.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ExportController::download
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ExportController.php:119
* @route '/activitylog-ui/export/download'
*/
download.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(options),
    method: 'head',
})

const exportMethod = {
    download: Object.assign(download, download),
}

export default exportMethod