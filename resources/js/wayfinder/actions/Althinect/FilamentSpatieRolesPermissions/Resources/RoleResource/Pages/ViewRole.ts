import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
const ViewRole = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewRole.url(args, options),
    method: 'get',
})

ViewRole.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
ViewRole.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ViewRole.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
ViewRole.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ViewRole.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
ViewRole.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ViewRole.url(args, options),
    method: 'head',
})

export default ViewRole