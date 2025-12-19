import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
const ViewPermission = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewPermission.url(args, options),
    method: 'get',
})

ViewPermission.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
ViewPermission.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewPermission.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
ViewPermission.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewPermission.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
ViewPermission.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewPermission.url(args, options),
    method: 'head',
})

export default ViewPermission