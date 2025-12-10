import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ListRoles::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ListRoles.php:7
* @route '/super-admin/roles'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\CreateRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/CreateRole.php:7
* @route '/super-admin/roles/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
export const edit = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
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
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
edit.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\EditRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/EditRole.php:7
* @route '/super-admin/roles/{record}/edit'
*/
edit.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
export const view = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

view.definition = {
    methods: ["get","head"],
    url: '/super-admin/roles/{record}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
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
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
view.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: view.url(args, options),
    method: 'get',
})

/**
* @see \Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource\Pages\ViewRole::__invoke
* @see vendor/althinect/filament-spatie-roles-permissions/src/Resources/RoleResource/Pages/ViewRole.php:7
* @route '/super-admin/roles/{record}'
*/
view.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: view.url(args, options),
    method: 'head',
})

const roles = {
    index: Object.assign(index, index),
    create: Object.assign(create, create),
    edit: Object.assign(edit, edit),
    view: Object.assign(view, view),
}

export default roles