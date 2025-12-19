import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/media',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const media = {
    index: Object.assign(index, index),
}

export default media