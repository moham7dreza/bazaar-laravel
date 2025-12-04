import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
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

const jobs = {
    show: Object.assign(show, show),
    retry: Object.assign(retry, retry),
}

export default jobs