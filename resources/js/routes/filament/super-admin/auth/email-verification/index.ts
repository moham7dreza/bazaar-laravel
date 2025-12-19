import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
export const prompt = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: prompt.url(options),
    method: 'get',
})

prompt.definition = {
    methods: ["get","head"],
    url: '/super-admin/email-verification/prompt',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
prompt.url = (options?: RouteQueryOptions) => {
    return prompt.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
prompt.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: prompt.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Auth\EmailVerification\EmailVerificationPrompt::__invoke
* @see vendor/filament/filament/src/Pages/Auth/EmailVerification/EmailVerificationPrompt.php:7
* @route '/super-admin/email-verification/prompt'
*/
prompt.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: prompt.url(options),
    method: 'head',
})

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
export const verify = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/super-admin/email-verification/verify/{id}/{hash}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
verify.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            id: args[0],
            hash: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
        hash: args.hash,
    }

    return verify.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
verify.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
verify.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(args, options),
    method: 'head',
})

const emailVerification = {
    prompt: Object.assign(prompt, prompt),
    verify: Object.assign(verify, verify),
}

export default emailVerification