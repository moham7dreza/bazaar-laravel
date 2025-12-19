import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
const MailPreviewController = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: MailPreviewController.url(args, options),
    method: 'get',
})

MailPreviewController.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/{mail}/preview',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
MailPreviewController.url = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { mail: args }
    }

    if (Array.isArray(args)) {
        args = {
            mail: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        mail: args.mail,
    }

    return MailPreviewController.definition.url
            .replace('{mail}', parsedArgs.mail.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
MailPreviewController.get = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: MailPreviewController.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
MailPreviewController.head = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: MailPreviewController.url(args, options),
    method: 'head',
})

export default MailPreviewController