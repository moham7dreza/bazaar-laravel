import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
const MyProfilePage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: MyProfilePage.url(options),
    method: 'get',
})

MyProfilePage.definition = {
    methods: ["get","head"],
    url: '/super-admin/my-profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
MyProfilePage.url = (options?: RouteQueryOptions) => {
    return MyProfilePage.definition.url + queryParams(options)
}

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
MyProfilePage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: MyProfilePage.url(options),
    method: 'get',
})

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
MyProfilePage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: MyProfilePage.url(options),
    method: 'head',
})

export default MyProfilePage