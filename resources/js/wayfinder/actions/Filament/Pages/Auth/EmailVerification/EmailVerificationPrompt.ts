import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
const EmailVerificationPrompt = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EmailVerificationPrompt.url(options),
    method: 'get',
})

EmailVerificationPrompt.definition = {
    methods: ["get","head"],
    url: '/super-admin/email-verification/prompt',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
EmailVerificationPrompt.url = (options?: RouteQueryOptions) => {
    return EmailVerificationPrompt.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
EmailVerificationPrompt.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EmailVerificationPrompt.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
EmailVerificationPrompt.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EmailVerificationPrompt.url(options),
    method: 'head',
})

export default EmailVerificationPrompt