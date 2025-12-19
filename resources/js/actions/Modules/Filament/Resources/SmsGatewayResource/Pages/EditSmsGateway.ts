import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
const EditSmsGateway = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSmsGateway.url(args, options),
    method: 'get',
})

EditSmsGateway.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-gateways/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
EditSmsGateway.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditSmsGateway.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
EditSmsGateway.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSmsGateway.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
EditSmsGateway.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditSmsGateway.url(args, options),
    method: 'head',
})

export default EditSmsGateway