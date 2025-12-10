import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:25
* @route '/api/panel/advertisements/gallery/{advertisement}'
*/
export const index = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/panel/advertisements/gallery/{advertisement}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:25
* @route '/api/panel/advertisements/gallery/{advertisement}'
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
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:25
* @route '/api/panel/advertisements/gallery/{advertisement}'
*/
index.get = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::index
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:25
* @route '/api/panel/advertisements/gallery/{advertisement}'
*/
index.head = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::store
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:38
* @route '/api/panel/advertisements/gallery/{advertisement}/store'
*/
export const store = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/panel/advertisements/gallery/{advertisement}/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::store
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:38
* @route '/api/panel/advertisements/gallery/{advertisement}/store'
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
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::store
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:38
* @route '/api/panel/advertisements/gallery/{advertisement}/store'
*/
store.post = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:64
* @route '/api/panel/advertisements/gallery/show/{gallery}'
*/
export const show = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/panel/advertisements/gallery/show/{gallery}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:64
* @route '/api/panel/advertisements/gallery/show/{gallery}'
*/
show.url = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { gallery: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { gallery: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            gallery: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        gallery: typeof args.gallery === 'object'
        ? args.gallery.id
        : args.gallery,
    }

    return show.definition.url
            .replace('{gallery}', parsedArgs.gallery.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:64
* @route '/api/panel/advertisements/gallery/show/{gallery}'
*/
show.get = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::show
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:64
* @route '/api/panel/advertisements/gallery/show/{gallery}'
*/
show.head = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:74
* @route '/api/panel/advertisements/gallery/{gallery}'
*/
export const update = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/api/panel/advertisements/gallery/{gallery}',
} satisfies RouteDefinition<["put"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:74
* @route '/api/panel/advertisements/gallery/{gallery}'
*/
update.url = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { gallery: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { gallery: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            gallery: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        gallery: typeof args.gallery === 'object'
        ? args.gallery.id
        : args.gallery,
    }

    return update.definition.url
            .replace('{gallery}', parsedArgs.gallery.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::update
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:74
* @route '/api/panel/advertisements/gallery/{gallery}'
*/
update.put = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::destroy
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:109
* @route '/api/panel/advertisements/gallery/{gallery}'
*/
export const destroy = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/panel/advertisements/gallery/{gallery}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::destroy
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:109
* @route '/api/panel/advertisements/gallery/{gallery}'
*/
destroy.url = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { gallery: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { gallery: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            gallery: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        gallery: typeof args.gallery === 'object'
        ? args.gallery.id
        : args.gallery,
    }

    return destroy.definition.url
            .replace('{gallery}', parsedArgs.gallery.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Panel\GalleryController::destroy
* @see modules/advertise/src/Http/Controllers/Panel/GalleryController.php:109
* @route '/api/panel/advertisements/gallery/{gallery}'
*/
destroy.delete = (args: { gallery: number | { id: number } } | [gallery: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const GalleryController = { index, store, show, update, destroy }

export default GalleryController