import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \Vormkracht10\Mails\Controllers\WebhookController::__invoke
* @see vendor/vormkracht10/laravel-mails/src/Controllers/WebhookController.php:13
* @route '/webhooks/mails/{provider}'
*/
export const webhook = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: webhook.url(args, options),
    method: 'post',
})

webhook.definition = {
    methods: ["post"],
    url: '/webhooks/mails/{provider}',
} satisfies RouteDefinition<["post"]>

/**
* @see \Vormkracht10\Mails\Controllers\WebhookController::__invoke
* @see vendor/vormkracht10/laravel-mails/src/Controllers/WebhookController.php:13
* @route '/webhooks/mails/{provider}'
*/
webhook.url = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { provider: args }
    }

    if (Array.isArray(args)) {
        args = {
            provider: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        provider: args.provider,
    }

    return webhook.definition.url
            .replace('{provider}', parsedArgs.provider.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Vormkracht10\Mails\Controllers\WebhookController::__invoke
* @see vendor/vormkracht10/laravel-mails/src/Controllers/WebhookController.php:13
* @route '/webhooks/mails/{provider}'
*/
webhook.post = (args: { provider: string | number } | [provider: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: webhook.url(args, options),
    method: 'post',
})

const mails = {
    webhook: Object.assign(webhook, webhook),
}

export default mails