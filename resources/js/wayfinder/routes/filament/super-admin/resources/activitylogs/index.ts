import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/activitylogs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/activitylogs/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
view.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return view.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ViewActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ViewActivitylog.php:7
* @route '/super-admin/activitylogs/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const activitylogs = {
    index: Object.assign(index, index),
    view: Object.assign(view, view),
}

export default activitylogs