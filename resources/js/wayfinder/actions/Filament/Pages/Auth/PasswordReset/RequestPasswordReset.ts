import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
const RequestPasswordReset = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RequestPasswordReset.url(options),
    method: 'get',
})

RequestPasswordReset.definition = {
    methods: ["get","head"],
    url: '/super-admin/password-reset/request',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
RequestPasswordReset.url = (options?: RouteQueryOptions) => {
    return RequestPasswordReset.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
RequestPasswordReset.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RequestPasswordReset.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\PasswordReset\RequestPasswordReset::__invoke
* @see vendor/filament/filament/src/Pages/Auth/PasswordReset/RequestPasswordReset.php:7
* @route '/super-admin/password-reset/request'
*/
RequestPasswordReset.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RequestPasswordReset.url(options),
    method: 'head',
})

export default RequestPasswordReset