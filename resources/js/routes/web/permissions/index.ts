import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\SyncRolePermissionsController::__invoke
* @see app/Http/Controllers/SyncRolePermissionsController.php:15
* @route '/role-permissions-sync'
*/
export const sync = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: sync.url(options),
    method: 'put',
})

sync.definition = {
    methods: ["put"],
    url: '/role-permissions-sync',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\SyncRolePermissionsController::__invoke
* @see app/Http/Controllers/SyncRolePermissionsController.php:15
* @route '/role-permissions-sync'
*/
sync.url = (options?: RouteQueryOptions) => {
    return sync.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SyncRolePermissionsController::__invoke
* @see app/Http/Controllers/SyncRolePermissionsController.php:15
* @route '/role-permissions-sync'
*/
sync.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: sync.url(options),
    method: 'put',
})

const permissions = {
    sync: Object.assign(sync, sync),
}

export default permissions