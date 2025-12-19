import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
const ViewEvent = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewEvent.url(args, options),
    method: 'get',
})

ViewEvent.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/events/{record}/view',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
ViewEvent.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewEvent.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
ViewEvent.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewEvent.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\EventResource\Pages\ViewEvent::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/EventResource/Pages/ViewEvent.php:7
* @route '/super-admin/mails/events/{record}/view'
*/
ViewEvent.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewEvent.url(args, options),
    method: 'head',
})

export default ViewEvent