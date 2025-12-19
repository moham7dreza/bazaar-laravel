import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
const ListMails = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMails.url(options),
    method: 'get',
})

ListMails.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
ListMails.url = (options?: RouteQueryOptions) => {
    return ListMails.definition.url + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
ListMails.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListMails.url(options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
ListMails.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListMails.url(options),
    method: 'head',
})

export default ListMails