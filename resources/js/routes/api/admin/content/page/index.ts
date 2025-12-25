import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::index
* @see modules/content/src/Http/Controllers/Admin/PageController.php:22
* @route '/api/admin/content/page'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/content/page',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::index
* @see modules/content/src/Http/Controllers/Admin/PageController.php:22
* @route '/api/admin/content/page'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::index
* @see modules/content/src/Http/Controllers/Admin/PageController.php:22
* @route '/api/admin/content/page'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::index
* @see modules/content/src/Http/Controllers/Admin/PageController.php:22
* @route '/api/admin/content/page'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::store
* @see modules/content/src/Http/Controllers/Admin/PageController.php:30
* @route '/api/admin/content/page'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/content/page',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::store
* @see modules/content/src/Http/Controllers/Admin/PageController.php:30
* @route '/api/admin/content/page'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::store
* @see modules/content/src/Http/Controllers/Admin/PageController.php:30
* @route '/api/admin/content/page'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::show
* @see modules/content/src/Http/Controllers/Admin/PageController.php:41
* @route '/api/admin/content/page/{page}'
*/
export const show = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/content/page/{page}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::show
* @see modules/content/src/Http/Controllers/Admin/PageController.php:41
* @route '/api/admin/content/page/{page}'
*/
show.url = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { page: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { page: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            page: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        page: typeof args.page === 'object'
        ? args.page.id
        : args.page,
    }

    return show.definition.url
            .replace('{page}', parsedArgs.page.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::show
* @see modules/content/src/Http/Controllers/Admin/PageController.php:41
* @route '/api/admin/content/page/{page}'
*/
show.get = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::show
* @see modules/content/src/Http/Controllers/Admin/PageController.php:41
* @route '/api/admin/content/page/{page}'
*/
show.head = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::update
* @see modules/content/src/Http/Controllers/Admin/PageController.php:49
* @route '/api/admin/content/page/{page}'
*/
export const update = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/content/page/{page}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::update
* @see modules/content/src/Http/Controllers/Admin/PageController.php:49
* @route '/api/admin/content/page/{page}'
*/
update.url = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { page: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { page: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            page: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        page: typeof args.page === 'object'
        ? args.page.id
        : args.page,
    }

    return update.definition.url
            .replace('{page}', parsedArgs.page.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::update
* @see modules/content/src/Http/Controllers/Admin/PageController.php:49
* @route '/api/admin/content/page/{page}'
*/
update.put = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::update
* @see modules/content/src/Http/Controllers/Admin/PageController.php:49
* @route '/api/admin/content/page/{page}'
*/
update.patch = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::destroy
* @see modules/content/src/Http/Controllers/Admin/PageController.php:60
* @route '/api/admin/content/page/{page}'
*/
export const destroy = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/content/page/{page}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::destroy
* @see modules/content/src/Http/Controllers/Admin/PageController.php:60
* @route '/api/admin/content/page/{page}'
*/
destroy.url = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { page: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { page: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            page: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        page: typeof args.page === 'object'
        ? args.page.id
        : args.page,
    }

    return destroy.definition.url
            .replace('{page}', parsedArgs.page.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\PageController::destroy
* @see modules/content/src/Http/Controllers/Admin/PageController.php:60
* @route '/api/admin/content/page/{page}'
*/
destroy.delete = (args: { page: number | { id: number } } | [page: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const page = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default page