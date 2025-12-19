import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserWithOTPController.php:24
* @route '/api/auth/send-otp'
*/
const RegisteredUserWithOTPController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RegisteredUserWithOTPController.url(options),
    method: 'post',
})

RegisteredUserWithOTPController.definition = {
    methods: ["post"],
    url: '/api/auth/send-otp',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserWithOTPController.php:24
* @route '/api/auth/send-otp'
*/
RegisteredUserWithOTPController.url = (options?: RouteQueryOptions) => {
    return RegisteredUserWithOTPController.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserWithOTPController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserWithOTPController.php:24
* @route '/api/auth/send-otp'
*/
RegisteredUserWithOTPController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RegisteredUserWithOTPController.url(options),
    method: 'post',
})

export default RegisteredUserWithOTPController