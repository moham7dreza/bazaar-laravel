import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../../wayfinder'
/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
const ListMonitoredScheduledTasks = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMonitoredScheduledTasks.url(options),
    method: 'get',
})

ListMonitoredScheduledTasks.definition = {
    methods: ["get","head"],
    url: '/super-admin/monitored-scheduled-tasks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
ListMonitoredScheduledTasks.url = (options?: RouteQueryOptions) => {
    return ListMonitoredScheduledTasks.definition.url + queryParams(options)
}

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
ListMonitoredScheduledTasks.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMonitoredScheduledTasks.url(options),
    method: 'get',
})

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
ListMonitoredScheduledTasks.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMonitoredScheduledTasks.url(options),
    method: 'head',
})

export default ListMonitoredScheduledTasks