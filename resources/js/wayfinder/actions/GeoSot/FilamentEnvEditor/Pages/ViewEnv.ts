import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
const ViewEnv = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewEnv.url(options),
    method: 'get',
})

ViewEnv.definition = {
    methods: ["get","head"],
    url: '/super-admin/env-editor',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
ViewEnv.url = (options?: RouteQueryOptions) => {
    return ViewEnv.definition.url + queryParams(options)
}

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
ViewEnv.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewEnv.url(options),
    method: 'get',
})

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
ViewEnv.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewEnv.url(options),
    method: 'head',
})

export default ViewEnv