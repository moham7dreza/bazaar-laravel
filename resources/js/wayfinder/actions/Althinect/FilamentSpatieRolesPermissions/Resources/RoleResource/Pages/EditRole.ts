import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
const EditRole = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditRole.url(args, options),
    method: 'get',
})

EditRole.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
EditRole.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditRole.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
EditRole.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditRole.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
EditRole.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditRole.url(args, options),
    method: 'head',
})

export default EditRole