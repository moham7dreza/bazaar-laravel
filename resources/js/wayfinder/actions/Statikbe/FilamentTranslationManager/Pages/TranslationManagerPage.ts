import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
const TranslationManagerPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: TranslationManagerPage.url(options),
    method: 'get',
})

TranslationManagerPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/translation-manager-page',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
TranslationManagerPage.url = (options?: RouteQueryOptions) => {
    return TranslationManagerPage.definition.url + queryParams(options)
}

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
TranslationManagerPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: TranslationManagerPage.url(options),
    method: 'get',
})

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
TranslationManagerPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: TranslationManagerPage.url(options),
    method: 'head',
})

export default TranslationManagerPage