import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
const LocationSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LocationSettings.url(options),
    method: 'get',
})

LocationSettings.definition = {
    methods: ["get","head"],
    url: '/super-admin/location-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
LocationSettings.url = (options?: RouteQueryOptions) => {
    return LocationSettings.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
LocationSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LocationSettings.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
LocationSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LocationSettings.url(options),
    method: 'head',
})

export default LocationSettings