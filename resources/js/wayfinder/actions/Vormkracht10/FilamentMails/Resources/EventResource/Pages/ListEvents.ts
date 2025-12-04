import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
const ListEvents = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListEvents.url(options),
    method: 'get',
})

ListEvents.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
ListEvents.url = (options?: RouteQueryOptions) => {
    return ListEvents.definition.url + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
ListEvents.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListEvents.url(options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
ListEvents.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListEvents.url(options),
    method: 'head',
})

export default ListEvents