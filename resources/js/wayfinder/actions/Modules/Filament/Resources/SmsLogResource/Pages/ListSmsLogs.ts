import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ListSmsLogs.php:7
* @route '/super-admin/sms-logs'
*/
const ListSmsLogs = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSmsLogs.url(options),
    method: 'get',
})

ListSmsLogs.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-logs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ListSmsLogs.php:7
* @route '/super-admin/sms-logs'
*/
ListSmsLogs.url = (options?: RouteQueryOptions) => {
    return ListSmsLogs.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ListSmsLogs.php:7
* @route '/super-admin/sms-logs'
*/
ListSmsLogs.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSmsLogs.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ListSmsLogs.php:7
* @route '/super-admin/sms-logs'
*/
ListSmsLogs.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSmsLogs.url(options),
    method: 'head',
})

export default ListSmsLogs