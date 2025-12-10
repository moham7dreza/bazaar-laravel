import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::index
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:22
* @route '/api/admin/advertisements/state'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/state',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::index
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:22
* @route '/api/admin/advertisements/state'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::index
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:22
* @route '/api/admin/advertisements/state'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::index
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:22
* @route '/api/admin/advertisements/state'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::store
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:30
* @route '/api/admin/advertisements/state'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/advertisements/state',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::store
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:30
* @route '/api/admin/advertisements/state'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::store
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:30
* @route '/api/admin/advertisements/state'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::show
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:41
* @route '/api/admin/advertisements/state/{state}'
*/
export const show = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/state/{state}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::show
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:41
* @route '/api/admin/advertisements/state/{state}'
*/
show.url = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { state: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { state: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            state: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        state: typeof args.state === 'object'
        ? args.state.id
        : args.state,
    }

    return show.definition.url
            .replace('{state}', parsedArgs.state.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::show
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:41
* @route '/api/admin/advertisements/state/{state}'
*/
show.get = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::show
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:41
* @route '/api/admin/advertisements/state/{state}'
*/
show.head = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::update
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:49
* @route '/api/admin/advertisements/state/{state}'
*/
export const update = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/advertisements/state/{state}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::update
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:49
* @route '/api/admin/advertisements/state/{state}'
*/
update.url = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { state: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { state: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            state: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        state: typeof args.state === 'object'
        ? args.state.id
        : args.state,
    }

    return update.definition.url
            .replace('{state}', parsedArgs.state.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::update
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:49
* @route '/api/admin/advertisements/state/{state}'
*/
update.put = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::update
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:49
* @route '/api/admin/advertisements/state/{state}'
*/
update.patch = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:60
* @route '/api/admin/advertisements/state/{state}'
*/
export const destroy = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/advertisements/state/{state}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:60
* @route '/api/admin/advertisements/state/{state}'
*/
destroy.url = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { state: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { state: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            state: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        state: typeof args.state === 'object'
        ? args.state.id
        : args.state,
    }

    return destroy.definition.url
            .replace('{state}', parsedArgs.state.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\StateController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/StateController.php:60
* @route '/api/admin/advertisements/state/{state}'
*/
destroy.delete = (args: { state: number | { id: number } } | [state: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const StateController = { index, store, show, update, destroy }

export default StateController