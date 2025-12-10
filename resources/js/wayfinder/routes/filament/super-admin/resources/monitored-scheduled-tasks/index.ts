import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/monitored-scheduled-tasks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Mvenghaus\FilamentScheduleMonitor\Filament\Resources\MonitoredScheduledTaskResource\Pages\ListMonitoredScheduledTasks::__invoke
* @see vendor/mvenghaus/filament-plugin-schedule-monitor/src/Filament/Resources/MonitoredScheduledTaskResource/Pages/ListMonitoredScheduledTasks.php:7
* @route '/super-admin/monitored-scheduled-tasks'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const monitoredScheduledTasks = {
    index: Object.assign(index, index),
}

export default monitoredScheduledTasks