import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:21
* @route '/api/admin/advertisements/category-attribute'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/category-attribute',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:21
* @route '/api/admin/advertisements/category-attribute'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:21
* @route '/api/admin/advertisements/category-attribute'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::index
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:21
* @route '/api/admin/advertisements/category-attribute'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:29
* @route '/api/admin/advertisements/category-attribute'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/api/admin/advertisements/category-attribute',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:29
* @route '/api/admin/advertisements/category-attribute'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::store
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:29
* @route '/api/admin/advertisements/category-attribute'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:40
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
export const show = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/api/admin/advertisements/category-attribute/{category_attribute}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:40
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
show.url = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_attribute: args }
    }

    if (Array.isArray(args)) {
        args = {
            category_attribute: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_attribute: args.category_attribute,
    }

    return show.definition.url
            .replace('{category_attribute}', parsedArgs.category_attribute.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:40
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
show.get = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::show
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:40
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
show.head = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:48
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
export const update = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/api/admin/advertisements/category-attribute/{category_attribute}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:48
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
update.url = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_attribute: args }
    }

    if (Array.isArray(args)) {
        args = {
            category_attribute: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_attribute: args.category_attribute,
    }

    return update.definition.url
            .replace('{category_attribute}', parsedArgs.category_attribute.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:48
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
update.put = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::update
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:48
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
update.patch = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:59
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
export const destroy = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/api/admin/advertisements/category-attribute/{category_attribute}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:59
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
destroy.url = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { category_attribute: args }
    }

    if (Array.isArray(args)) {
        args = {
            category_attribute: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        category_attribute: args.category_attribute,
    }

    return destroy.definition.url
            .replace('{category_attribute}', parsedArgs.category_attribute.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Modules\Advertise\Http\Controllers\Admin\CategoryAttributeController::destroy
* @see modules/advertise/src/Http/Controllers/Admin/CategoryAttributeController.php:59
* @route '/api/admin/advertisements/category-attribute/{category_attribute}'
*/
destroy.delete = (args: { category_attribute: string | number } | [category_attribute: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const CategoryAttributeController = { index, store, show, update, destroy }

export default CategoryAttributeController