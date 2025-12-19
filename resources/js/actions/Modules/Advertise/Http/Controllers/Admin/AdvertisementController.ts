import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:31
* @route '/api/admin/advertisements/advertisement'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/advertisement',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:31
* @route '/api/admin/advertisements/advertisement'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:31
* @route '/api/admin/advertisements/advertisement'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::index
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:31
* @route '/api/admin/advertisements/advertisement'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::store
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:43
* @route '/api/admin/advertisements/advertisement'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/advertisements/advertisement',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::store
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:43
* @route '/api/admin/advertisements/advertisement'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::store
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:43
* @route '/api/admin/advertisements/advertisement'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:80
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
export const show = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/advertisement/{advertisement}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:80
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
show.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { advertisement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { advertisement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
    }

    return show.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:80
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
show.get = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::show
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:80
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
show.head = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::update
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:88
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
export const update = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/advertisements/advertisement/{advertisement}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::update
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:88
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
update.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { advertisement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { advertisement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
    }

    return update.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::update
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:88
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
update.put = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::update
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:88
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
update.patch = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:134
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
export const destroy = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/advertisements/advertisement/{advertisement}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:134
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
destroy.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { advertisement: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { advertisement: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
    }

    return destroy.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\AdvertisementController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/AdvertisementController.php:134
* @route '/api/admin/advertisements/advertisement/{advertisement}'
*/
destroy.delete = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const AdvertisementController = { index, store, show, update, destroy }

export default AdvertisementController