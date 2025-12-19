import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:22
* @route '/api/admin/advertisements/category'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/category',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:22
* @route '/api/admin/advertisements/category'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:22
* @route '/api/admin/advertisements/category'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:22
* @route '/api/admin/advertisements/category'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:30
* @route '/api/admin/advertisements/category'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/advertisements/category',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:30
* @route '/api/admin/advertisements/category'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:30
* @route '/api/admin/advertisements/category'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:41
* @route '/api/admin/advertisements/category/{category}'
*/
export const show = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/category/{category}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:41
* @route '/api/admin/advertisements/category/{category}'
*/
show.url = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category: typeof args.category === 'object'
        ? args.category.id
        : args.category,
    }

    return show.definition.url
            .replace('{category}', parsedArgs.category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:41
* @route '/api/admin/advertisements/category/{category}'
*/
show.get = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:41
* @route '/api/admin/advertisements/category/{category}'
*/
show.head = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:49
* @route '/api/admin/advertisements/category/{category}'
*/
export const update = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/advertisements/category/{category}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:49
* @route '/api/admin/advertisements/category/{category}'
*/
update.url = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category: typeof args.category === 'object'
        ? args.category.id
        : args.category,
    }

    return update.definition.url
            .replace('{category}', parsedArgs.category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:49
* @route '/api/admin/advertisements/category/{category}'
*/
update.put = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:49
* @route '/api/admin/advertisements/category/{category}'
*/
update.patch = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:60
* @route '/api/admin/advertisements/category/{category}'
*/
export const destroy = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/advertisements/category/{category}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:60
* @route '/api/admin/advertisements/category/{category}'
*/
destroy.url = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { category: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            category: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category: typeof args.category === 'object'
        ? args.category.id
        : args.category,
    }

    return destroy.definition.url
            .replace('{category}', parsedArgs.category.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryController.php:60
* @route '/api/admin/advertisements/category/{category}'
*/
destroy.delete = (args: { category: number | { id: number } } | [category: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const CategoryController = { index, store, show, update, destroy }

export default CategoryController