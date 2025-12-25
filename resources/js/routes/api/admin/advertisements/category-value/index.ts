import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:21
* @route '/api/admin/advertisements/category-value'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/category-value',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:21
* @route '/api/admin/advertisements/category-value'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:21
* @route '/api/admin/advertisements/category-value'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:21
* @route '/api/admin/advertisements/category-value'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:29
* @route '/api/admin/advertisements/category-value'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/advertisements/category-value',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:29
* @route '/api/admin/advertisements/category-value'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:29
* @route '/api/admin/advertisements/category-value'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:40
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
export const show = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/category-value/{category_value}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:40
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
show.url = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_value: args }
    }

    if (Array.isArray(args)) {
        args = {
            category_value: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_value: args.category_value,
    }

    return show.definition.url
            .replace('{category_value}', parsedArgs.category_value.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:40
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
show.get = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:40
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
show.head = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:48
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
export const update = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/advertisements/category-value/{category_value}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:48
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
update.url = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_value: args }
    }

    if (Array.isArray(args)) {
        args = {
            category_value: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_value: args.category_value,
    }

    return update.definition.url
            .replace('{category_value}', parsedArgs.category_value.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:48
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
update.put = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:48
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
update.patch = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:59
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
export const destroy = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/advertisements/category-value/{category_value}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:59
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
destroy.url = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_value: args }
    }

    if (Array.isArray(args)) {
        args = {
            category_value: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_value: args.category_value,
    }

    return destroy.definition.url
            .replace('{category_value}', parsedArgs.category_value.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryValueController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryValueController.php:59
* @route '/api/admin/advertisements/category-value/{category_value}'
*/
destroy.delete = (args: { category_value: string | number } | [category_value: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const categoryValue = {
    index: Object.assign(index, index),
    store: Object.assign(store, store),
    show: Object.assign(show, show),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
}

export default categoryValue