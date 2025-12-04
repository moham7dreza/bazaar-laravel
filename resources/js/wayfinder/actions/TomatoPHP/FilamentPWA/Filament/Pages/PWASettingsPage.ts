import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
const PWASettingsPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PWASettingsPage.url(options),
    method: 'get',
})

PWASettingsPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/pwa-settings-page',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
PWASettingsPage.url = (options?: RouteQueryOptions) => {
    return PWASettingsPage.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
PWASettingsPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PWASettingsPage.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
PWASettingsPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: PWASettingsPage.url(options),
    method: 'head',
})

export default PWASettingsPage