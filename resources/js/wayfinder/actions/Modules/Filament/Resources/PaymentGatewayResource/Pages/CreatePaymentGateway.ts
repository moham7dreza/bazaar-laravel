import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\CreatePaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/CreatePaymentGateway.php:7
* @route '/super-admin/payment-gateways/create'
*/
const CreatePaymentGateway = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreatePaymentGateway.url(options),
    method: 'get',
})

CreatePaymentGateway.definition = {
    methods: ["get","head"],
    url: '/super-admin/payment-gateways/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\CreatePaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/CreatePaymentGateway.php:7
* @route '/super-admin/payment-gateways/create'
*/
CreatePaymentGateway.url = (options?: RouteQueryOptions) => {
    return CreatePaymentGateway.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\CreatePaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/CreatePaymentGateway.php:7
* @route '/super-admin/payment-gateways/create'
*/
CreatePaymentGateway.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreatePaymentGateway.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\CreatePaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/CreatePaymentGateway.php:7
* @route '/super-admin/payment-gateways/create'
*/
CreatePaymentGateway.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreatePaymentGateway.url(options),
    method: 'head',
})

export default CreatePaymentGateway