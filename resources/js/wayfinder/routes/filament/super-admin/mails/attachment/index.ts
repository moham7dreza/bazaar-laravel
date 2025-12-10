import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Vormkracht10\FilamentMails\Controllers\MailDownloadController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailDownloadController.php:10
* @route '/super-admin/mails/{mail}/attachment/{attachment}/{filename}'
*/
export const download = (args: { mail: string | number, attachment: string | number, filename: string | number } | [mail: string | number, attachment: string | number, filename: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/super-admin/mails/{mail}/attachment/{attachment}/{filename}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailDownloadController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailDownloadController.php:10
* @route '/super-admin/mails/{mail}/attachment/{attachment}/{filename}'
*/
download.url = (args: { mail: string | number, attachment: string | number, filename: string | number } | [mail: string | number, attachment: string | number, filename: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            mail: args[0],
            attachment: args[1],
            filename: args[2],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        mail: args.mail,
        attachment: args.attachment,
        filename: args.filename,
    }

    return download.definition.url
            .replace('{mail}', parsedArgs.mail.toString())
            .replace('{attachment}', parsedArgs.attachment.toString())
            .replace('{filename}', parsedArgs.filename.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailDownloadController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailDownloadController.php:10
* @route '/super-admin/mails/{mail}/attachment/{attachment}/{filename}'
*/
download.get = (args: { mail: string | number, attachment: string | number, filename: string | number } | [mail: string | number, attachment: string | number, filename: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \Vormkracht10\FilamentMails\Controllers\MailDownloadController::__invoke
* @see vendor/vormkracht10/filament-mails/src/Controllers/MailDownloadController.php:10
* @route '/super-admin/mails/{mail}/attachment/{attachment}/{filename}'
*/
download.head = (args: { mail: string | number, attachment: string | number, filename: string | number } | [mail: string | number, attachment: string | number, filename: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

const attachment = {
    download: Object.assign(download, download),
}

export default attachment