import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see vendor/stechstudio/filament-impersonate/routes/web.php:6
* @route '/filament-impersonate/leave'
*/
export const leave = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: leave.url(options),
    method: 'get',
})

leave.definition = {
    methods: ["get","head"],
    url: '/filament-impersonate/leave',
} satisfies RouteDefinition<["get","head"]>

/**
* @see vendor/stechstudio/filament-impersonate/routes/web.php:6
* @route '/filament-impersonate/leave'
*/
leave.url = (options?: RouteQueryOptions) => {
    return leave.definition.url + queryParams(options)
}

/**
* @see vendor/stechstudio/filament-impersonate/routes/web.php:6
* @route '/filament-impersonate/leave'
*/
leave.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: leave.url(options),
    method: 'get',
})

/**
* @see vendor/stechstudio/filament-impersonate/routes/web.php:6
* @route '/filament-impersonate/leave'
*/
leave.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: leave.url(options),
    method: 'head',
})

const filamentImpersonate = {
    leave: Object.assign(leave, leave),
}

export default filamentImpersonate