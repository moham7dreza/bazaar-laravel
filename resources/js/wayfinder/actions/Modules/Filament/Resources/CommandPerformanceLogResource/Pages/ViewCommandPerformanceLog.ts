import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
const ViewCommandPerformanceLog = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewCommandPerformanceLog.url(args, options),
    method: 'get',
})

ViewCommandPerformanceLog.definition = {
    methods: ["get","head"],
    url: '/super-admin/command-performance-logs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
ViewCommandPerformanceLog.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewCommandPerformanceLog.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
ViewCommandPerformanceLog.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewCommandPerformanceLog.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
ViewCommandPerformanceLog.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewCommandPerformanceLog.url(args, options),
    method: 'head',
})

export default ViewCommandPerformanceLog