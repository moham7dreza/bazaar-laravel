import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
const ForbiddenPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ForbiddenPage.url(options),
    method: 'get',
})

ForbiddenPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/403',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
ForbiddenPage.url = (options?: RouteQueryOptions) => {
    return ForbiddenPage.definition.url + queryParams(options)
}

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
ForbiddenPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ForbiddenPage.url(options),
    method: 'get',
})

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
ForbiddenPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ForbiddenPage.url(options),
    method: 'head',
})

export default ForbiddenPage