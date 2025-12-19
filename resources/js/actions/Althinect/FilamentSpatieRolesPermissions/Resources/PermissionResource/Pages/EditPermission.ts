import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
const EditPermission = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditPermission.url(args, options),
    method: 'get',
})

EditPermission.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
EditPermission.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditPermission.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
EditPermission.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditPermission.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
EditPermission.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditPermission.url(args, options),
    method: 'head',
})

export default EditPermission