import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::manifest
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
export const manifest = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manifest.url(options),
    method: 'get',
})

manifest.definition = {
    methods: ["get","head"],
    url: '/manifest.json',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::manifest
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
manifest.url = (options?: RouteQueryOptions) => {
    return manifest.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::manifest
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
manifest.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: manifest.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::manifest
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
manifest.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: manifest.url(options),
    method: 'head',
})

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::offline
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:15
* @route '/offline'
*/
export const offline = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: offline.url(options),
    method: 'get',
})

offline.definition = {
    methods: ["get","head"],
    url: '/offline',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::offline
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:15
* @route '/offline'
*/
offline.url = (options?: RouteQueryOptions) => {
    return offline.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::offline
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:15
* @route '/offline'
*/
offline.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: offline.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::offline
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:15
* @route '/offline'
*/
offline.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: offline.url(options),
    method: 'head',
})

const pwa = {
    manifest: Object.assign(manifest, manifest),
    offline: Object.assign(offline, offline),
}

export default pwa