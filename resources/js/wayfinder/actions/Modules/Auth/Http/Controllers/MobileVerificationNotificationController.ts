import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\MobileVerificationNotificationController::store
* @see modules/auth/src/Http/Controllers/MobileVerificationNotificationController.php:17
* @route '/mobile/verification-notification'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/mobile/verification-notification',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\MobileVerificationNotificationController::store
* @see modules/auth/src/Http/Controllers/MobileVerificationNotificationController.php:17
* @route '/mobile/verification-notification'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\MobileVerificationNotificationController::store
* @see modules/auth/src/Http/Controllers/MobileVerificationNotificationController.php:17
* @route '/mobile/verification-notification'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const MobileVerificationNotificationController = { store }

export default MobileVerificationNotificationController