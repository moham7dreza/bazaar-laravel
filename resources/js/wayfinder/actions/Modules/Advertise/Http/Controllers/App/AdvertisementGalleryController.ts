import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementGalleryController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementGalleryController.php:19
* @route '/api/advertisements/{advertisement}/gallery'
*/
export const index = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/advertisements/{advertisement}/gallery',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementGalleryController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementGalleryController.php:19
* @route '/api/advertisements/{advertisement}/gallery'
*/
index.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { advertisement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { advertisement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
    }

    return index.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementGalleryController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementGalleryController.php:19
* @route '/api/advertisements/{advertisement}/gallery'
*/
index.get = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\App\AdvertisementGalleryController::index
* @see modules/advertise/src/Http/Controllers/App/AdvertisementGalleryController.php:19
* @route '/api/advertisements/{advertisement}/gallery'
*/
index.head = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

const AdvertisementGalleryController = { index }

export default AdvertisementGalleryController