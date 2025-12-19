import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
import passwordReset from './password-reset'
import emailVerification from './email-verification'
/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/super-admin/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \Afsakar\FilamentOtpLogin\Filament\Pages\Login::__invoke
* @see vendor/afsakar/filament-otp-login/src/Filament/Pages/Login.php:7
* @route '/super-admin/login'
*/
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
export const register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/super-admin/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(options),
    method: 'head',
})

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/super-admin/logout'
*/
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/super-admin/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/super-admin/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \Filament\Http\Controllers\Auth\LogoutController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/LogoutController.php:10
* @route '/super-admin/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
export const twoFactor = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: twoFactor.url(options),
    method: 'get',
})

twoFactor.definition = {
    methods: ["get","head"],
    url: '/super-admin/two-factor-authentication',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
twoFactor.url = (options?: RouteQueryOptions) => {
    return twoFactor.definition.url + queryParams(options)
}

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
twoFactor.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: twoFactor.url(options),
    method: 'get',
})

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
twoFactor.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: twoFactor.url(options),
    method: 'head',
})

const auth = {
    login: Object.assign(login, login),
    passwordReset: Object.assign(passwordReset, passwordReset),
    register: Object.assign(register, register),
    logout: Object.assign(logout, logout),
    emailVerification: Object.assign(emailVerification, emailVerification),
    twoFactor: Object.assign(twoFactor, twoFactor),
}

export default auth