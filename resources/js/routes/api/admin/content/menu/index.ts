import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::index
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:22
* @route '/api/admin/content/menu'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/content/menu',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::index
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:22
* @route '/api/admin/content/menu'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::index
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:22
* @route '/api/admin/content/menu'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::index
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:22
* @route '/api/admin/content/menu'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::store
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:30
* @route '/api/admin/content/menu'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/content/menu',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::store
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:30
* @route '/api/admin/content/menu'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::store
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:30
* @route '/api/admin/content/menu'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::show
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:41
* @route '/api/admin/content/menu/{menu}'
*/
export const show = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/content/menu/{menu}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::show
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:41
* @route '/api/admin/content/menu/{menu}'
*/
show.url = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { menu: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { menu: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            menu: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        menu: typeof args.menu === 'object'
        ? args.menu.id
        : args.menu,
    }

    return show.definition.url
            .replace('{menu}', parsedArgs.menu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::show
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:41
* @route '/api/admin/content/menu/{menu}'
*/
show.get = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::show
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:41
* @route '/api/admin/content/menu/{menu}'
*/
show.head = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::update
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:49
* @route '/api/admin/content/menu/{menu}'
*/
export const update = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/content/menu/{menu}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::update
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:49
* @route '/api/admin/content/menu/{menu}'
*/
update.url = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { menu: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { menu: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            menu: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        menu: typeof args.menu === 'object'
        ? args.menu.id
        : args.menu,
    }

    return update.definition.url
            .replace('{menu}', parsedArgs.menu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::update
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:49
* @route '/api/admin/content/menu/{menu}'
*/
update.put = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::update
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:49
* @route '/api/admin/content/menu/{menu}'
*/
update.patch = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::destroy
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:60
* @route '/api/admin/content/menu/{menu}'
*/
export const destroy = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/content/menu/{menu}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::destroy
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:60
* @route '/api/admin/content/menu/{menu}'
*/
destroy.url = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { menu: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { menu: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            menu: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        menu: typeof args.menu === 'object'
        ? args.menu.id
        : args.menu,
    }

    return destroy.definition.url
            .replace('{menu}', parsedArgs.menu.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Content\Http\Controllers\Admin\MenuController::destroy
* @see modules/content/src/Http/Controllers/Admin/MenuController.php:60
* @route '/api/admin/content/menu/{menu}'
*/
destroy.delete = (args: { menu: number | { id: number } } | [menu: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const menu = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default menu