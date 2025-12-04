import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\VerifyUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyUserWithOTPController.php:20
* @route '/api/auth/verify-otp'
*/
const VerifyUserWithOTPController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: VerifyUserWithOTPController.url(options),
    method: 'post',
})

VerifyUserWithOTPController.definition = {
    methods: ["post"],
    url: '/api/auth/verify-otp',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\VerifyUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyUserWithOTPController.php:20
* @route '/api/auth/verify-otp'
*/
VerifyUserWithOTPController.url = (options?: RouteQueryOptions) => {
    return VerifyUserWithOTPController.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\VerifyUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyUserWithOTPController.php:20
* @route '/api/auth/verify-otp'
*/
VerifyUserWithOTPController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: VerifyUserWithOTPController.url(options),
    method: 'post',
})

export default VerifyUserWithOTPController