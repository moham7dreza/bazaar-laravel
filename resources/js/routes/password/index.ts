import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\PasswordResetLinkController::email
* @see modules/auth/src/Http/Controllers/PasswordResetLinkController.php:20
* @route '/forgot-password'
*/
export const email = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: email.url(options),
    method: 'post',
})

email.definition = {
    methods: ["post"],
    url: '/forgot-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\PasswordResetLinkController::email
* @see modules/auth/src/Http/Controllers/PasswordResetLinkController.php:20
* @route '/forgot-password'
*/
email.url = (options?: RouteQueryOptions) => {
    return email.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\PasswordResetLinkController::email
* @see modules/auth/src/Http/Controllers/PasswordResetLinkController.php:20
* @route '/forgot-password'
*/
email.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: email.url(options),
    method: 'post',
})

/**
* @see \Modules\Auth\Http\Controllers\NewPasswordController::store
* @see modules/auth/src/Http/Controllers/NewPasswordController.php:23
* @route '/reset-password'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/reset-password',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\NewPasswordController::store
* @see modules/auth/src/Http/Controllers/NewPasswordController.php:23
* @route '/reset-password'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\NewPasswordController::store
* @see modules/auth/src/Http/Controllers/NewPasswordController.php:23
* @route '/reset-password'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const password = {
    email: Object.assign(email, email),
    store: Object.assign(store, store),
}

export default password