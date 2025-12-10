import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\EditPaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/EditPaymentGateway.php:7
* @route '/super-admin/payment-gateways/{record}/edit'
*/
const EditPaymentGateway = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditPaymentGateway.url(args, options),
    method: 'get',
})

EditPaymentGateway.definition = {
    methods: ["get","head"],
    url: '/super-admin/payment-gateways/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\EditPaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/EditPaymentGateway.php:7
* @route '/super-admin/payment-gateways/{record}/edit'
*/
EditPaymentGateway.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditPaymentGateway.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\EditPaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/EditPaymentGateway.php:7
* @route '/super-admin/payment-gateways/{record}/edit'
*/
EditPaymentGateway.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditPaymentGateway.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\PaymentGatewayResource\Pages\EditPaymentGateway::__invoke
* @see modules/filament/src/Resources/PaymentGatewayResource/Pages/EditPaymentGateway.php:7
* @route '/super-admin/payment-gateways/{record}/edit'
*/
EditPaymentGateway.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditPaymentGateway.url(args, options),
    method: 'head',
})

export default EditPaymentGateway