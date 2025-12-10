import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
const CreateSmsGateway = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSmsGateway.url(options),
    method: 'get',
})

CreateSmsGateway.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-gateways/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
CreateSmsGateway.url = (options?: RouteQueryOptions) => {
    return CreateSmsGateway.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
CreateSmsGateway.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSmsGateway.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\CreateSmsGateway::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/CreateSmsGateway.php:7
* @route '/super-admin/sms-gateways/create'
*/
CreateSmsGateway.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateSmsGateway.url(options),
    method: 'head',
})

export default CreateSmsGateway