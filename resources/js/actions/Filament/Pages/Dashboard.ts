import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
const Dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Dashboard.url(options),
    method: 'get',
})

Dashboard.definition = {
    methods: ["get","head"],
    url: '/super-admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
Dashboard.url = (options?: RouteQueryOptions) => {
    return Dashboard.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
Dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: Dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
Dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: Dashboard.url(options),
    method: 'head',
})

export default Dashboard