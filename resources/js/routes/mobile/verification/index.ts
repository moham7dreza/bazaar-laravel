import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\MobileVerificationNotificationController::send
* @see modules/auth/src/Http/Controllers/MobileVerificationNotificationController.php:17
* @route '/mobile/verification-notification'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/mobile/verification-notification',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\MobileVerificationNotificationController::send
* @see modules/auth/src/Http/Controllers/MobileVerificationNotificationController.php:17
* @route '/mobile/verification-notification'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\MobileVerificationNotificationController::send
* @see modules/auth/src/Http/Controllers/MobileVerificationNotificationController.php:17
* @route '/mobile/verification-notification'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

const verification = {
    send: Object.assign(send, send),
}

export default verification