import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
const ListActivitylog = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListActivitylog.url(options),
    method: 'get',
})

ListActivitylog.definition = {
    methods: ["get","head"],
    url: '/super-admin/activitylogs',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
ListActivitylog.url = (options?: RouteQueryOptions) => {
    return ListActivitylog.definition.url + queryParams(options)
}

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
ListActivitylog.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListActivitylog.url(options),
    method: 'get',
})

/**
* @see \Rmsramos\Activitylog\Resources\ActivitylogResource\Pages\ListActivitylog::__invoke
* @see vendor/rmsramos/activitylog/src/Resources/ActivitylogResource/Pages/ListActivitylog.php:7
* @route '/super-admin/activitylogs'
*/
ListActivitylog.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListActivitylog.url(options),
    method: 'head',
})

export default ListActivitylog