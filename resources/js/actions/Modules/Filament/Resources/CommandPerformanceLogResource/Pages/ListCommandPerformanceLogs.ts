import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
const ListCommandPerformanceLogs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListCommandPerformanceLogs.url(options),
    method: 'get',
})

ListCommandPerformanceLogs.definition = {
    methods: ["get","head"],
    url: '/super-admin/command-performance-logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
ListCommandPerformanceLogs.url = (options?: RouteQueryOptions) => {
    return ListCommandPerformanceLogs.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
ListCommandPerformanceLogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListCommandPerformanceLogs.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs::__invoke
* @see modules/filament/src/Resources/CommandPerformanceLogResource/Pages/ListCommandPerformanceLogs.php:7
* @route '/super-admin/command-performance-logs'
*/
ListCommandPerformanceLogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListCommandPerformanceLogs.url(options),
    method: 'head',
})

export default ListCommandPerformanceLogs