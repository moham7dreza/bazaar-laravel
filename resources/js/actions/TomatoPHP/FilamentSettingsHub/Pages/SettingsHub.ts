import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
const SettingsHub = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SettingsHub.url(options),
    method: 'get',
})

SettingsHub.definition = {
    methods: ["get","head"],
    url: '/super-admin/settings-hub',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
SettingsHub.url = (options?: RouteQueryOptions) => {
    return SettingsHub.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
SettingsHub.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SettingsHub.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
SettingsHub.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SettingsHub.url(options),
    method: 'head',
})

export default SettingsHub