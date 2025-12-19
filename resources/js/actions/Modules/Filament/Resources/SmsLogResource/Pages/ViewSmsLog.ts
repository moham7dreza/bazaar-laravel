import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ViewSmsLog::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ViewSmsLog.php:7
* @route '/super-admin/sms-logs/{record}'
*/
const ViewSmsLog = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewSmsLog.url(args, options),
    method: 'get',
})

ViewSmsLog.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-logs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ViewSmsLog::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ViewSmsLog.php:7
* @route '/super-admin/sms-logs/{record}'
*/
ViewSmsLog.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewSmsLog.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ViewSmsLog::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ViewSmsLog.php:7
* @route '/super-admin/sms-logs/{record}'
*/
ViewSmsLog.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewSmsLog.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsLogResource\Pages\ViewSmsLog::__invoke
* @see modules/filament/src/Resources/SmsLogResource/Pages/ViewSmsLog.php:7
* @route '/super-admin/sms-logs/{record}'
*/
ViewSmsLog.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewSmsLog.url(args, options),
    method: 'head',
})

export default ViewSmsLog