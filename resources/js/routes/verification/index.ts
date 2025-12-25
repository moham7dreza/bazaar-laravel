import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\VerifyEmailController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyEmailController.php:17
* @route '/verify-email/{id}/{hash}'
*/
export const verify = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/verify-email/{id}/{hash}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Auth\Http\Controllers\VerifyEmailController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyEmailController.php:17
* @route '/verify-email/{id}/{hash}'
*/
verify.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            id: args[0],
            hash: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
        hash: args.hash,
    }

    return verify.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\VerifyEmailController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyEmailController.php:17
* @route '/verify-email/{id}/{hash}'
*/
verify.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Auth\Http\Controllers\VerifyEmailController::__invoke
* @see modules/auth/src/Http/Controllers/VerifyEmailController.php:17
* @route '/verify-email/{id}/{hash}'
*/
verify.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Auth\Http\Controllers\EmailVerificationNotificationController::send
* @see modules/auth/src/Http/Controllers/EmailVerificationNotificationController.php:17
* @route '/email/verification-notification'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/email/verification-notification',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\EmailVerificationNotificationController::send
* @see modules/auth/src/Http/Controllers/EmailVerificationNotificationController.php:17
* @route '/email/verification-notification'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\EmailVerificationNotificationController::send
* @see modules/auth/src/Http/Controllers/EmailVerificationNotificationController.php:17
* @route '/email/verification-notification'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

const verification = {
    verify: Object.assign(verify, verify),
    send: Object.assign(send, send),
}

export default verification