import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::index
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:19
* @route '/vantage'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/vantage',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::index
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:19
* @route '/vantage'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::index
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:19
* @route '/vantage'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::index
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:19
* @route '/vantage'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:246
* @route '/vantage/jobs'
*/
export const jobs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jobs.url(options),
    method: 'get',
})

jobs.definition = {
    methods: ["get","head"],
    url: '/vantage/jobs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:246
* @route '/vantage/jobs'
*/
jobs.url = (options?: RouteQueryOptions) => {
    return jobs.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:246
* @route '/vantage/jobs'
*/
jobs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jobs.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:246
* @route '/vantage/jobs'
*/
jobs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: jobs.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::show
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:394
* @route '/vantage/jobs/{id}'
*/
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/vantage/jobs/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::show
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:394
* @route '/vantage/jobs/{id}'
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
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::show
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:394
* @route '/vantage/jobs/{id}'
*/
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::show
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:394
* @route '/vantage/jobs/{id}'
*/
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:410
* @route '/vantage/tags'
*/
export const tags = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tags.url(options),
    method: 'get',
})

tags.definition = {
    methods: ["get","head"],
    url: '/vantage/tags',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:410
* @route '/vantage/tags'
*/
tags.url = (options?: RouteQueryOptions) => {
    return tags.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:410
* @route '/vantage/tags'
*/
tags.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tags.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:410
* @route '/vantage/tags'
*/
tags.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: tags.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:466
* @route '/vantage/failed'
*/
export const failed = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: failed.url(options),
    method: 'get',
})

failed.definition = {
    methods: ["get","head"],
    url: '/vantage/failed',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:466
* @route '/vantage/failed'
*/
failed.url = (options?: RouteQueryOptions) => {
    return failed.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:466
* @route '/vantage/failed'
*/
failed.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: failed.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:466
* @route '/vantage/failed'
*/
failed.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: failed.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::retry
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:487
* @route '/vantage/jobs/{id}/retry'
*/
export const retry = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: retry.url(args, options),
    method: 'post',
})

retry.definition = {
    methods: ["post"],
    url: '/vantage/jobs/{id}/retry',
} satisfies RouteDefinition<["post"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::retry
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:487
* @route '/vantage/jobs/{id}/retry'
*/
retry.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return retry.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::retry
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:487
* @route '/vantage/jobs/{id}/retry'
*/
retry.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: retry.url(args, options),
    method: 'post',
})

const QueueMonitorController = { index, jobs, show, tags, failed, retry }

export default QueueMonitorController