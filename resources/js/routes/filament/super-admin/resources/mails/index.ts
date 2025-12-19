import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
import events from './events'
import suppressions from './suppressions'
/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ListMails::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ListMails.php:7
* @route '/super-admin/mails'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/{record}/view',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
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
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const mails = {
    index: Object.assign(index, index),
    view: Object.assign(view, view),
    events: Object.assign(events, events),
    suppressions: Object.assign(suppressions, suppressions),
}

export default mails