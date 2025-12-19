import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
const SiteSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SiteSettings.url(options),
    method: 'get',
})

SiteSettings.definition = {
    methods: ["get","head"],
    url: '/super-admin/site-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
SiteSettings.url = (options?: RouteQueryOptions) => {
    return SiteSettings.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
SiteSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SiteSettings.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
SiteSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SiteSettings.url(options),
    method: 'head',
})

export default SiteSettings