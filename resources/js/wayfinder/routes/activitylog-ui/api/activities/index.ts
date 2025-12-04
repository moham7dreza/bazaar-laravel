import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/activities',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::show
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/activities/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::show
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
show.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return show.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::show
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::show
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::related
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
export const related = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: related.url(args, options),
    method: 'get',
})

related.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/activities/{id}/related',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::related
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
related.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return related.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::related
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
related.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: related.url(args, options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::related
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
related.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: related.url(args, options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
export const recent = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recent.url(options),
    method: 'get',
})

recent.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/recent',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
recent.url = (options?: RouteQueryOptions) => {
    return recent.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
recent.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recent.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
recent.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: recent.url(options),
    method: 'head',
})

const activities = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
    related: Object.assign(related, related),
    recent: Object.assign(recent, recent),
}

export default activities