import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
const ViewActivitylog = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewActivitylog.url(args, options),
    method: 'get',
})

ViewActivitylog.definition = {
    methods: ["get","head"],
    url: '/super-admin/activitylogs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
ViewActivitylog.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewActivitylog.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
ViewActivitylog.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewActivitylog.url(args, options),
    method: 'get',
})

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
ViewActivitylog.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewActivitylog.url(args, options),
    method: 'head',
})

export default ViewActivitylog