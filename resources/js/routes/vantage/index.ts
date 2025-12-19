import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import jobsF3446c from './jobs'
/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::dashboard
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:21
* @route '/vantage'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/vantage',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::dashboard
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:21
* @route '/vantage'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::dashboard
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:21
* @route '/vantage'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::dashboard
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:21
* @route '/vantage'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:224
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
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:224
* @route '/vantage/jobs'
*/
jobs.url = (options?: RouteQueryOptions) => {
    return jobs.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:224
* @route '/vantage/jobs'
*/
jobs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jobs.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::jobs
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:224
* @route '/vantage/jobs'
*/
jobs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: jobs.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:368
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
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:368
* @route '/vantage/tags'
*/
tags.url = (options?: RouteQueryOptions) => {
    return tags.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:368
* @route '/vantage/tags'
*/
tags.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tags.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::tags
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:368
* @route '/vantage/tags'
*/
tags.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: tags.url(options),
    method: 'head',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:383
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
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:383
* @route '/vantage/failed'
*/
failed.url = (options?: RouteQueryOptions) => {
    return failed.definition.url + queryParams(options)
}

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:383
* @route '/vantage/failed'
*/
failed.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: failed.url(options),
    method: 'get',
})

/**
* @see \HoudaSlassi\Vantage\Http\Controllers\QueueMonitorController::failed
* @see vendor/houdaslassi/vantage/src/Http/Controllers/QueueMonitorController.php:383
* @route '/vantage/failed'
*/
failed.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: failed.url(options),
    method: 'head',
})

const vantage = {
    dashboard: Object.assign(dashboard, dashboard),
    jobs: Object.assign(jobs, jobsF3446c),
    tags: Object.assign(tags, tags),
    failed: Object.assign(failed, failed),
}

export default vantage