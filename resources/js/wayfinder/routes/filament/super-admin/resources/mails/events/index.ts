import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/events',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ListEvents::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ListEvents.php:7
* @route '/super-admin/mails/events'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/events/{record}/view',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
view.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return view.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const events = {
    index: Object.assign(index, index),
    view: Object.assign(view, view),
}

export default events