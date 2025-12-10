import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
export const request = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

request.definition = {
    methods: ["get","head"],
    url: '/super-admin/password-reset/request',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
request.url = (options?: RouteQueryOptions) => {
    return request.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
request.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: request.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
request.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: request.url(options),
    method: 'head',
})

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
export const reset = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reset.url(options),
    method: 'get',
})

reset.definition = {
    methods: ["get","head"],
    url: '/super-admin/password-reset/reset',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
reset.url = (options?: RouteQueryOptions) => {
    return reset.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
reset.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: reset.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
reset.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: reset.url(options),
    method: 'head',
})

const passwordReset = {
    request: Object.assign(request, request),
    reset: Object.assign(reset, reset),
}

export default passwordReset