import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
const Login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Login.url(options),
    method: 'get',
})

Login.definition = {
    methods: ["get","head"],
    url: '/super-admin/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
Login.url = (options?: RouteQueryOptions) => {
    return Login.definition.url + queryParams(options)
}

/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
Login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Login.url(options),
    method: 'get',
})

/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
Login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Login.url(options),
    method: 'head',
})

export default Login