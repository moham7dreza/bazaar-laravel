import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
const PageNotFoundPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PageNotFoundPage.url(options),
    method: 'get',
})

PageNotFoundPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/404',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
PageNotFoundPage.url = (options?: RouteQueryOptions) => {
    return PageNotFoundPage.definition.url + queryParams(options)
}

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
PageNotFoundPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PageNotFoundPage.url(options),
    method: 'get',
})

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
PageNotFoundPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: PageNotFoundPage.url(options),
    method: 'head',
})

export default PageNotFoundPage