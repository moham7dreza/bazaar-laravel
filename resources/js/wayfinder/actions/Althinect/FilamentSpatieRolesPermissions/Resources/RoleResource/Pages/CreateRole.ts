import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
const CreateRole = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateRole.url(options),
    method: 'get',
})

CreateRole.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
CreateRole.url = (options?: RouteQueryOptions) => {
    return CreateRole.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
CreateRole.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateRole.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
CreateRole.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateRole.url(options),
    method: 'head',
})

export default CreateRole