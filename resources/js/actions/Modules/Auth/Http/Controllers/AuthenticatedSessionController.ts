import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::store
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:17
* @route '/login'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::store
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:17
* @route '/login'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::store
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:17
* @route '/login'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::destroy
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:31
* @route '/logout'
*/
export const destroy = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: destroy.url(options),
    method: 'post',
})

destroy.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::destroy
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:31
* @route '/logout'
*/
destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::destroy
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:31
* @route '/logout'
*/
destroy.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: destroy.url(options),
    method: 'post',
})

const AuthenticatedSessionController = { store, destroy }

export default AuthenticatedSessionController