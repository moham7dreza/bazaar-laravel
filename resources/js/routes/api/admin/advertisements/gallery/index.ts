import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:27
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
export const index = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/{advertisement}/gallery',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:27
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
index.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return index.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:27
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
index.get = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:27
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
index.head = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::store
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:37
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
export const store = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/advertisements/{advertisement}/gallery',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::store
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:37
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
store.url = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::store
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:37
* @route '/api/admin/advertisements/{advertisement}/gallery'
*/
store.post = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:57
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
export const show = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/{advertisement}/gallery/{gallery}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:57
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
show.url = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
            gallery: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
        gallery: typeof args.gallery === 'object'
        ? args.gallery.id
        : args.gallery,
    }

    return show.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace('{gallery}', parsedArgs.gallery.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:57
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
show.get = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:57
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
show.head = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:65
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
export const update = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/advertisements/{advertisement}/gallery/{gallery}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:65
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
update.url = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
            gallery: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
        gallery: typeof args.gallery === 'object'
        ? args.gallery.id
        : args.gallery,
    }

    return update.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace('{gallery}', parsedArgs.gallery.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:65
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
update.put = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:65
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
update.patch = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:84
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
export const destroy = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/advertisements/{advertisement}/gallery/{gallery}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:84
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
destroy.url = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            advertisement: args[0],
            gallery: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        advertisement: typeof args.advertisement === 'object'
        ? args.advertisement.id
        : args.advertisement,
        gallery: typeof args.gallery === 'object'
        ? args.gallery.id
        : args.gallery,
    }

    return destroy.definition.url
            .replace('{advertisement}', parsedArgs.advertisement.toString())
            .replace('{gallery}', parsedArgs.gallery.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\GalleryController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/GalleryController.php:84
* @route '/api/admin/advertisements/{advertisement}/gallery/{gallery}'
*/
destroy.delete = (args: { advertisement: number | { id: number }, gallery: number | { id: number } } | [advertisement: number | { id: number }, gallery: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const gallery = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default gallery