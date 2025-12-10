import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\ListPaymentGateways::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/ListPaymentGateways.php:7
* @route '/super-admin/payment-gateways'
*/
const ListPaymentGateways = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPaymentGateways.url(options),
    method: 'get',
})

ListPaymentGateways.definition = {
    methods: ["get","head"],
    url: '/super-admin/payment-gateways',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\ListPaymentGateways::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/ListPaymentGateways.php:7
* @route '/super-admin/payment-gateways'
*/
ListPaymentGateways.url = (options?: RouteQueryOptions) => {
    return ListPaymentGateways.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\ListPaymentGateways::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/ListPaymentGateways.php:7
* @route '/super-admin/payment-gateways'
*/
ListPaymentGateways.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPaymentGateways.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\ListPaymentGateways::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/ListPaymentGateways.php:7
* @route '/super-admin/payment-gateways'
*/
ListPaymentGateways.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListPaymentGateways.url(options),
    method: 'head',
})

export default ListPaymentGateways