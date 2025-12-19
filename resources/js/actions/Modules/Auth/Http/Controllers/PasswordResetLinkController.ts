import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\PasswordResetLinkController::store
* @see modules/auth/src/Http/Controllers/PasswordResetLinkController.php:20
* @route '/forgot-password'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/forgot-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\PasswordResetLinkController::store
* @see modules/auth/src/Http/Controllers/PasswordResetLinkController.php:20
* @route '/forgot-password'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\PasswordResetLinkController::store
* @see modules/auth/src/Http/Controllers/PasswordResetLinkController.php:20
* @route '/forgot-password'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const PasswordResetLinkController = { store }

export default PasswordResetLinkController