import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SyncRolePermissionsController::__invoke
* @see app/Http/Controllers/SyncRolePermissionsController.php:15
* @route '/role-permissions-sync'
*/
const SyncRolePermissionsController = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: SyncRolePermissionsController.url(options),
    method: 'put',
})

SyncRolePermissionsController.definition = {
    methods: ["put"],
    url: '/role-permissions-sync',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\SyncRolePermissionsController::__invoke
* @see app/Http/Controllers/SyncRolePermissionsController.php:15
* @route '/role-permissions-sync'
*/
SyncRolePermissionsController.url = (options?: RouteQueryOptions) => {
    return SyncRolePermissionsController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SyncRolePermissionsController::__invoke
* @see app/Http/Controllers/SyncRolePermissionsController.php:15
* @route '/role-permissions-sync'
*/
SyncRolePermissionsController.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: SyncRolePermissionsController.url(options),
    method: 'put',
})

export default SyncRolePermissionsController