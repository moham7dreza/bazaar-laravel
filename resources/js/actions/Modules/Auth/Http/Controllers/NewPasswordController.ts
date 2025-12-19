import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
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

const NewPasswordController = { store }

export default NewPasswordController