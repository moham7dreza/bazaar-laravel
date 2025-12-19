import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
const EmailVerificationController = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EmailVerificationController.url(args, options),
    method: 'get',
})

EmailVerificationController.definition = {
    methods: ["get","head"],
    url: '/super-admin/email-verification/verify/{id}/{hash}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
EmailVerificationController.url = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions) => {
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

    return EmailVerificationController.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace('{hash}', parsedArgs.hash.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
EmailVerificationController.get = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EmailVerificationController.url(args, options),
    method: 'get',
})

/**
* @see \Filament\Http\Controllers\Auth\EmailVerificationController::__invoke
* @see vendor/filament/filament/src/Http/Controllers/Auth/EmailVerificationController.php:10
* @route '/super-admin/email-verification/verify/{id}/{hash}'
*/
EmailVerificationController.head = (args: { id: string | number, hash: string | number } | [id: string | number, hash: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EmailVerificationController.url(args, options),
    method: 'head',
})

export default EmailVerificationController