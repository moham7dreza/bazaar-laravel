import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
const Themes = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Themes.url(options),
    method: 'get',
})

Themes.definition = {
    methods: ["get","head"],
    url: '/super-admin/themes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
Themes.url = (options?: RouteQueryOptions) => {
    return Themes.definition.url + queryParams(options)
}

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
Themes.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Themes.url(options),
    method: 'get',
})

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
Themes.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Themes.url(options),
    method: 'head',
})

export default Themes