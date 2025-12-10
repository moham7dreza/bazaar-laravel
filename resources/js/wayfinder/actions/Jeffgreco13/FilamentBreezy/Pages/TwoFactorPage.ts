import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
const TwoFactorPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: TwoFactorPage.url(options),
    method: 'get',
})

TwoFactorPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/two-factor-authentication',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
TwoFactorPage.url = (options?: RouteQueryOptions) => {
    return TwoFactorPage.definition.url + queryParams(options)
}

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
TwoFactorPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: TwoFactorPage.url(options),
    method: 'get',
})

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\TwoFactorPage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/TwoFactorPage.php:7
* @route '/super-admin/two-factor-authentication'
*/
TwoFactorPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: TwoFactorPage.url(options),
    method: 'head',
})

export default TwoFactorPage