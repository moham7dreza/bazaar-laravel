import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::index
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/manifest.json',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::index
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::index
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentPWA\Http\Controllers\PWAController::index
* @see vendor/tomatophp/filament-pwa/src/Http/Controllers/PWAController.php:10
* @route '/manifest.json'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
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

const PWAController = { index, offline }

export default PWAController