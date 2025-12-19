import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\UserResource\Pages\ListUsers::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/ListUsers.php:7
* @route '/super-admin/users'
*/
const ListUsers = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListUsers.url(options),
    method: 'get',
})

ListUsers.definition = {
    methods: ["get","head"],
    url: '/super-admin/users',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\UserResource\Pages\ListUsers::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/ListUsers.php:7
* @route '/super-admin/users'
*/
ListUsers.url = (options?: RouteQueryOptions) => {
    return ListUsers.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\UserResource\Pages\ListUsers::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/ListUsers.php:7
* @route '/super-admin/users'
*/
ListUsers.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListUsers.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\UserResource\Pages\ListUsers::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/ListUsers.php:7
* @route '/super-admin/users'
*/
ListUsers.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListUsers.url(options),
    method: 'head',
})

export default ListUsers