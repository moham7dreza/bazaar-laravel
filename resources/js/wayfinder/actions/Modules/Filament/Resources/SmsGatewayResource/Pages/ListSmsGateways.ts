import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
const ListSmsGateways = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSmsGateways.url(options),
    method: 'get',
})

ListSmsGateways.definition = {
    methods: ["get","head"],
    url: '/super-admin/sms-gateways',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
ListSmsGateways.url = (options?: RouteQueryOptions) => {
    return ListSmsGateways.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
ListSmsGateways.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSmsGateways.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\SmsGatewayResource\Pages\ListSmsGateways::__invoke
* @see modules/filament/src/Resources/SmsGatewayResource/Pages/ListSmsGateways.php:7
* @route '/super-admin/sms-gateways'
*/
ListSmsGateways.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSmsGateways.url(options),
    method: 'head',
})

export default ListSmsGateways