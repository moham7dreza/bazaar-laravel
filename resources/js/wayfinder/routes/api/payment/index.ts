import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Modules\Payment\Http\Controllers\PaymentController::create
* @see modules/payment/src/Http/Controllers/PaymentController.php:27
* @route '/payments/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: create.url(options),
    method: 'post',
})

create.definition = {
    methods: ["post"],
    url: '/payments/create',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::create
* @see modules/payment/src/Http/Controllers/PaymentController.php:27
* @route '/payments/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \Modules\Payment\Http\Controllers\PaymentController::create
* @see modules/payment/src/Http/Controllers/PaymentController.php:27
* @route '/payments/create'
*/
create.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: create.url(options),
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

const payment = {
    create: Object.assign(create, create),
    verify: Object.assign(verify, verify),
}

export default payment