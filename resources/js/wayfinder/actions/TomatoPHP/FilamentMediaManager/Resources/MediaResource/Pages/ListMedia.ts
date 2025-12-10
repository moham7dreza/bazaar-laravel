import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
const ListMedia = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMedia.url(options),
    method: 'get',
})

ListMedia.definition = {
    methods: ["get","head"],
    url: '/super-admin/media',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
ListMedia.url = (options?: RouteQueryOptions) => {
    return ListMedia.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
ListMedia.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMedia.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\MediaResource\Pages\ListMedia::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/MediaResource/Pages/ListMedia.php:7
* @route '/super-admin/media'
*/
ListMedia.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMedia.url(options),
    method: 'head',
})

export default ListMedia