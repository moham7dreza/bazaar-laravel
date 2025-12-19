import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
import attachment from './attachment'
/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
export const preview = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: preview.url(args, options),
    method: 'get',
})

preview.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/{mail}/preview',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
preview.url = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return preview.definition.url
            .replace('{mail}', parsedArgs.mail.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
preview.get = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: preview.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailPreviewController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailPreviewController.php:11
* @route '/super-admin/mails/{mail}/preview'
*/
preview.head = (args: { mail: string | number } | [mail: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: preview.url(args, options),
    method: 'head',
})

const mails = {
    preview: Object.assign(preview, preview),
    attachment: Object.assign(attachment, attachment),
}

export default mails