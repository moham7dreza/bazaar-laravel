import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
const ListFolders = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListFolders.url(options),
    method: 'get',
})

ListFolders.definition = {
    methods: ["get","head"],
    url: '/super-admin/folders',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
ListFolders.url = (options?: RouteQueryOptions) => {
    return ListFolders.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
ListFolders.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListFolders.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentMediaManager\Resources\FolderResource\Pages\ListFolders::__invoke
* @see vendor/tomatophp/filament-media-manager/src/Resources/FolderResource/Pages/ListFolders.php:7
* @route '/super-admin/folders'
*/
ListFolders.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListFolders.url(options),
    method: 'head',
})

export default ListFolders