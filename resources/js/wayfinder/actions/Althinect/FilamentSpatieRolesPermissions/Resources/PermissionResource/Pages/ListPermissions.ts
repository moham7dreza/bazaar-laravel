import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
const ListPermissions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPermissions.url(options),
    method: 'get',
})

ListPermissions.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
ListPermissions.url = (options?: RouteQueryOptions) => {
    return ListPermissions.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
ListPermissions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPermissions.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
ListPermissions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListPermissions.url(options),
    method: 'head',
})

export default ListPermissions