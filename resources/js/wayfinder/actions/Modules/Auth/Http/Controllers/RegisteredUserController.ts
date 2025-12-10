import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserController.php:21
* @route '/api/auth/register'
*/
const RegisteredUserController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RegisteredUserController.url(options),
    method: 'post',
})

RegisteredUserController.definition = {
    methods: ["post"],
    url: '/api/auth/register',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserController.php:21
* @route '/api/auth/register'
*/
RegisteredUserController.url = (options?: RouteQueryOptions) => {
    return RegisteredUserController.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\RegisteredUserController::__invoke
* @see modules/auth/src/Http/Controllers/RegisteredUserController.php:21
* @route '/api/auth/register'
*/
RegisteredUserController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RegisteredUserController.url(options),
    method: 'post',
})

export default RegisteredUserController