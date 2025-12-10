import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
const Register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Register.url(options),
    method: 'get',
})

Register.definition = {
    methods: ["get","head"],
    url: '/super-admin/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
Register.url = (options?: RouteQueryOptions) => {
    return Register.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
Register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Register.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\Register::__invoke
* @see vendor/filament/filament/src/Pages/Auth/Register.php:7
* @route '/super-admin/register'
*/
Register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Register.url(options),
    method: 'head',
})

export default Register