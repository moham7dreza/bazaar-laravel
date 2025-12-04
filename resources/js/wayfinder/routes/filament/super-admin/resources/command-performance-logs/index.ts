import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/command-performance-logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/command-performance-logs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
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
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ViewCommandPerformanceLog::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ViewCommandPerformanceLog.php:7
* @route '/super-admin/command-performance-logs/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const commandPerformanceLogs = {
    index: Object.assign(index, index),
    view: Object.assign(view, view),
}

export default commandPerformanceLogs