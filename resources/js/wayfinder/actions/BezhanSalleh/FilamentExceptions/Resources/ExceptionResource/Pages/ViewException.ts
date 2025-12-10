import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ViewException::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ViewException.php:7
* @route '/super-admin/exceptions/{record}'
*/
const ViewException = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewException.url(args, options),
    method: 'get',
})

ViewException.definition = {
    methods: ["get","head"],
    url: '/super-admin/exceptions/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ViewException::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ViewException.php:7
* @route '/super-admin/exceptions/{record}'
*/
ViewException.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewException.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ViewException::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ViewException.php:7
* @route '/super-admin/exceptions/{record}'
*/
ViewException.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewException.url(args, options),
    method: 'get',
})

/**
* @see \BezhanSalleh\FilamentExceptions\Resources\ExceptionResource\Pages\ViewException::__invoke
* @see vendor/bezhansalleh/filament-exceptions/src/Resources/ExceptionResource/Pages/ViewException.php:7
* @route '/super-admin/exceptions/{record}'
*/
ViewException.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewException.url(args, options),
    method: 'head',
})

export default ViewException