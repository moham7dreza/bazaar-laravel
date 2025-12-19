import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
const SocialMenuSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SocialMenuSettings.url(options),
    method: 'get',
})

SocialMenuSettings.definition = {
    methods: ["get","head"],
    url: '/super-admin/social-menu-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
SocialMenuSettings.url = (options?: RouteQueryOptions) => {
    return SocialMenuSettings.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
SocialMenuSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SocialMenuSettings.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
SocialMenuSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SocialMenuSettings.url(options),
    method: 'head',
})

export default SocialMenuSettings