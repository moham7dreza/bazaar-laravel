import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\EmailVerificationNotificationController::store
* @see modules/auth/src/Http/Controllers/EmailVerificationNotificationController.php:17
* @route '/email/verification-notification'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/email/verification-notification',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\EmailVerificationNotificationController::store
* @see modules/auth/src/Http/Controllers/EmailVerificationNotificationController.php:17
* @route '/email/verification-notification'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\EmailVerificationNotificationController::store
* @see modules/auth/src/Http/Controllers/EmailVerificationNotificationController.php:17
* @route '/email/verification-notification'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const EmailVerificationNotificationController = { store }

export default EmailVerificationNotificationController