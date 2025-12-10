import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../../wayfinder'
/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskLogItemResource\Pages\ListMonitoredScheduledTaskLogItems::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskLogItemResource/Pages/ListMonitoredScheduledTaskLogItems.php:7
* @route '/super-admin/monitored-scheduled-task-log-items'
*/
const ListMonitoredScheduledTaskLogItems = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMonitoredScheduledTaskLogItems.url(options),
    method: 'get',
})

ListMonitoredScheduledTaskLogItems.definition = {
    methods: ["get","head"],
    url: '/super-admin/monitored-scheduled-task-log-items',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskLogItemResource\Pages\ListMonitoredScheduledTaskLogItems::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskLogItemResource/Pages/ListMonitoredScheduledTaskLogItems.php:7
* @route '/super-admin/monitored-scheduled-task-log-items'
*/
ListMonitoredScheduledTaskLogItems.url = (options?: RouteQueryOptions) => {
    return ListMonitoredScheduledTaskLogItems.definition.url + queryParams(options)
}

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskLogItemResource\Pages\ListMonitoredScheduledTaskLogItems::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskLogItemResource/Pages/ListMonitoredScheduledTaskLogItems.php:7
* @route '/super-admin/monitored-scheduled-task-log-items'
*/
ListMonitoredScheduledTaskLogItems.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMonitoredScheduledTaskLogItems.url(options),
    method: 'get',
})

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskLogItemResource\Pages\ListMonitoredScheduledTaskLogItems::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskLogItemResource/Pages/ListMonitoredScheduledTaskLogItems.php:7
* @route '/super-admin/monitored-scheduled-task-log-items'
*/
ListMonitoredScheduledTaskLogItems.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMonitoredScheduledTaskLogItems.url(options),
    method: 'head',
})

export default ListMonitoredScheduledTaskLogItems