import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/super-admin/locks',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Kenepa\ResourceLock\Resources\LockResource\ManageResourceLocks::__invoke
* @see vendor/kenepa/resource-lock/src/Resources/LockResource/ManageResourceLocks.php:7
* @route '/super-admin/locks'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const locks = {
    index: Object.assign(index, index),
}

export default locks