import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserController.php:21
* @route '/api/auth/register'
*/
export const register = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(options),
    method: 'post',
})

register.definition = {
    methods: ["post"],
    url: '/api/auth/register',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserController.php:21
* @route '/api/auth/register'
*/
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserController.php:21
* @route '/api/auth/register'
*/
register.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(options),
    method: 'post',
})

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserWithOTPController.php:24
* @route '/api/auth/send-otp'
*/
export const sendOtp = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendOtp.url(options),
    method: 'post',
})

sendOtp.definition = {
    methods: ["post"],
    url: '/api/auth/send-otp',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserWithOTPController.php:24
* @route '/api/auth/send-otp'
*/
sendOtp.url = (options?: RouteQueryOptions) => {
    return sendOtp.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserWithOTPController.php:24
* @route '/api/auth/send-otp'
*/
sendOtp.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sendOtp.url(options),
    method: 'post',
})

/**
* @see \Modules\Auth\Http\Controllers\VerifyUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyUserWithOTPController.php:20
* @route '/api/auth/verify-otp'
*/
export const verifyOtp = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: verifyOtp.url(options),
    method: 'post',
})

verifyOtp.definition = {
    methods: ["post"],
    url: '/api/auth/verify-otp',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\VerifyUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyUserWithOTPController.php:20
* @route '/api/auth/verify-otp'
*/
verifyOtp.url = (options?: RouteQueryOptions) => {
    return verifyOtp.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\VerifyUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyUserWithOTPController.php:20
* @route '/api/auth/verify-otp'
*/
verifyOtp.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: verifyOtp.url(options),
    method: 'post',
})

const auth = {
    register: Object.assign(register, register),
    sendOtp: Object.assign(sendOtp, sendOtp),
    verifyOtp: Object.assign(verifyOtp, verifyOtp),
}

export default auth