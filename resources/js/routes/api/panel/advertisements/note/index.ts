import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::store
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:25
* @route '/api/panel/advertisements/notes/{advertisement}/store'
*/
export const store = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/panel/advertisements/notes/{advertisement}/store',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::store
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:25
* @route '/api/panel/advertisements/notes/{advertisement}/store'
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
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::store
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:25
* @route '/api/panel/advertisements/notes/{advertisement}/store'
*/
store.post = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::index
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:16
* @route '/api/panel/advertisements/notes'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/panel/advertisements/notes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::index
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:16
* @route '/api/panel/advertisements/notes'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::index
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:16
* @route '/api/panel/advertisements/notes'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::index
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:16
* @route '/api/panel/advertisements/notes'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::show
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:45
* @route '/api/panel/advertisements/notes/{advertisement}/show'
*/
export const show = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/panel/advertisements/notes/{advertisement}/show',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::show
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:45
* @route '/api/panel/advertisements/notes/{advertisement}/show'
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
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::show
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:45
* @route '/api/panel/advertisements/notes/{advertisement}/show'
*/
show.get = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::show
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:45
* @route '/api/panel/advertisements/notes/{advertisement}/show'
*/
show.head = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::destroy
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:60
* @route '/api/panel/advertisements/notes/{advertisement}/destroy'
*/
export const destroy = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/panel/advertisements/notes/{advertisement}/destroy',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::destroy
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:60
* @route '/api/panel/advertisements/notes/{advertisement}/destroy'
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
* @see \Modules\Advertise\Http\Controllers\Panel\AdvertisementNoteController::destroy
* @see modules/advertise/src/Http/Controllers/Panel/AdvertisementNoteController.php:60
* @route '/api/panel/advertisements/notes/{advertisement}/destroy'
*/
destroy.delete = (args: { advertisement: number | { id: number } } | [advertisement: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const note = {
    store: Object.assign(store, store),
    index: Object.assign(index, index),
    show: Object.assign(show, show),
    destroy: Object.assign(destroy, destroy),
}

export default note