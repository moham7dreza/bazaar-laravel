import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
const ViewJobPerformanceLog = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewJobPerformanceLog.url(args, options),
    method: 'get',
})

ViewJobPerformanceLog.definition = {
    methods: ["get","head"],
    url: '/super-admin/job-performance-logs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
ViewJobPerformanceLog.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewJobPerformanceLog.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
ViewJobPerformanceLog.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewJobPerformanceLog.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ViewJobPerformanceLog::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ViewJobPerformanceLog.php:7
* @route '/super-admin/job-performance-logs/{record}'
*/
ViewJobPerformanceLog.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewJobPerformanceLog.url(args, options),
    method: 'head',
})

export default ViewJobPerformanceLog