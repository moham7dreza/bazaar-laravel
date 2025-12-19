import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
const ViewMail = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewMail.url(args, options),
    method: 'get',
})

ViewMail.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/{record}/view',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
ViewMail.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewMail.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
ViewMail.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewMail.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Resources\MailResource\Pages\ViewMail::__invoke
* @see vendor/vormkracht10/filament-mails/src/Resources/MailResource/Pages/ViewMail.php:7
* @route '/super-admin/mails/{record}/view'
*/
ViewMail.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewMail.url(args, options),
    method: 'head',
})

export default ViewMail