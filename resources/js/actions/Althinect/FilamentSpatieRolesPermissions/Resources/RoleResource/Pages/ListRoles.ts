import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
const ListRoles = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListRoles.url(options),
    method: 'get',
})

ListRoles.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
ListRoles.url = (options?: RouteQueryOptions) => {
    return ListRoles.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
ListRoles.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListRoles.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
ListRoles.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListRoles.url(options),
    method: 'head',
})

export default ListRoles