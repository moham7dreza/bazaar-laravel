import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
const ResetPassword = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ResetPassword.url(options),
    method: 'get',
})

ResetPassword.definition = {
    methods: ["get","head"],
    url: '/super-admin/password-reset/reset',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
ResetPassword.url = (options?: RouteQueryOptions) => {
    return ResetPassword.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
ResetPassword.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ResetPassword.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\PasswordReset\ResetPassword::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/ResetPassword.php:7
* @route '/super-admin/password-reset/reset'
*/
ResetPassword.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ResetPassword.url(options),
    method: 'head',
})

export default ResetPassword