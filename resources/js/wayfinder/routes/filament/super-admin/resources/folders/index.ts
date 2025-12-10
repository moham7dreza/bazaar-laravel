import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/folders',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const folders = {
    index: Object.assign(index, index),
}

export default folders