import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/job-performance-logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/job-performance-logs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
view.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return view.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const jobPerformanceLogs = {
    index: Object.assign(index, index),
    view: Object.assign(view, view),
}

export default jobPerformanceLogs