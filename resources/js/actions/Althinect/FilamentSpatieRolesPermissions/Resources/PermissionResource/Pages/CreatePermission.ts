import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
const CreatePermission = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreatePermission.url(options),
    method: 'get',
})

CreatePermission.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
CreatePermission.url = (options?: RouteQueryOptions) => {
    return CreatePermission.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
CreatePermission.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreatePermission.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
CreatePermission.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreatePermission.url(options),
    method: 'head',
})

export default CreatePermission