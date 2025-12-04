import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-gateways',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-gateways/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-gateways/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
edit.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\EditSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/EditSmsGateway.php:7
* @route '/super-admin/sms-gateways/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

const smsGateways = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
}

export default smsGateways