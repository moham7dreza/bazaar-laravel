import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
const ManageResourceLocks = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ManageResourceLocks.url(options),
    method: 'get',
})

ManageResourceLocks.definition = {
    methods: ["get","head"],
    url: '/super-admin/locks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
ManageResourceLocks.url = (options?: RouteQueryOptions) => {
    return ManageResourceLocks.definition.url + queryParams(options)
}

/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
ManageResourceLocks.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ManageResourceLocks.url(options),
    method: 'get',
})

/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
ManageResourceLocks.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ManageResourceLocks.url(options),
    method: 'head',
})

export default ManageResourceLocks