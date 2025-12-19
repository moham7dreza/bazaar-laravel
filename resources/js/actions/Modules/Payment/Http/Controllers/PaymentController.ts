import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Payment\Http\Controllers\PaymentController::store
* @see modules/payment/src/Http/Controllers/PaymentController.php:27
* @route '/payments/create'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/payments/create',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::store
* @see modules/payment/src/Http/Controllers/PaymentController.php:27
* @route '/payments/create'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::store
* @see modules/payment/src/Http/Controllers/PaymentController.php:27
* @route '/payments/create'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::verify
* @see modules/payment/src/Http/Controllers/PaymentController.php:48
* @route '/payments/verify'
*/
export const verify = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/payments/verify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::verify
* @see modules/payment/src/Http/Controllers/PaymentController.php:48
* @route '/payments/verify'
*/
verify.url = (options?: RouteQueryOptions) => {
    return verify.definition.url + queryParams(options)
}

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::verify
* @see modules/payment/src/Http/Controllers/PaymentController.php:48
* @route '/payments/verify'
*/
verify.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(options),
    method: 'get',
})

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::verify
* @see modules/payment/src/Http/Controllers/PaymentController.php:48
* @route '/payments/verify'
*/
verify.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(options),
    method: 'head',
})

const PaymentController = { store, verify }

export default PaymentController