import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ListPermissions::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ListPermissions.php:7
* @route '/super-admin/permissions'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\CreatePermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/CreatePermission.php:7
* @route '/super-admin/permissions/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
edit.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\EditPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/EditPermission.php:7
* @route '/super-admin/permissions/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/permissions/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
view.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return view.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource\Pages\ViewPermission::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/PermissionResource/Pages/ViewPermission.php:7
* @route '/super-admin/permissions/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const permissions = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
    view: Object.assign(view, view),
}

export default permissions