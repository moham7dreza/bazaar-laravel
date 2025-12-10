import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
const ListJobPerformanceLogs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListJobPerformanceLogs.url(options),
    method: 'get',
})

ListJobPerformanceLogs.definition = {
    methods: ["get","head"],
    url: '/super-admin/job-performance-logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
ListJobPerformanceLogs.url = (options?: RouteQueryOptions) => {
    return ListJobPerformanceLogs.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
ListJobPerformanceLogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListJobPerformanceLogs.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs::__invoke
* @see modules/filament/src/Resources/JobPerformanceLogResource/Pages/ListJobPerformanceLogs.php:7
* @route '/super-admin/job-performance-logs'
*/
ListJobPerformanceLogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListJobPerformanceLogs.url(options),
    method: 'head',
})

export default ListJobPerformanceLogs