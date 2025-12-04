import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults, validateParameters } from './../wayfinder'
/**
* @see vendor/laravel/pulse/src/PulseServiceProvider.php:106
* @route '/pulse'
*/
export const pulse = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pulse.url(options),
    method: 'get',
})

pulse.definition = {
    methods: ["get","head"],
    url: '/pulse',
} satisfies RouteDefinition<["get","head"]>

/**
* @see vendor/laravel/pulse/src/PulseServiceProvider.php:106
* @route '/pulse'
*/
pulse.url = (options?: RouteQueryOptions) => {
    return pulse.definition.url + queryParams(options)
}

/**
* @see vendor/laravel/pulse/src/PulseServiceProvider.php:106
* @route '/pulse'
*/
pulse.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pulse.url(options),
    method: 'get',
})

/**
* @see vendor/laravel/pulse/src/PulseServiceProvider.php:106
* @route '/pulse'
*/
pulse.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pulse.url(options),
    method: 'head',
})

/**
* @see \Laravel\Telescope\Http\Controllers\HomeController::telescope
* @see vendor/laravel/telescope/src/Http/Controllers/HomeController.php:15
* @route '/telescope/{view?}'
*/
export const telescope = (args?: { view?: string | number } | [view: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: telescope.url(args, options),
    method: 'get',
})

telescope.definition = {
    methods: ["get","head"],
    url: '/telescope/{view?}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Telescope\Http\Controllers\HomeController::telescope
* @see vendor/laravel/telescope/src/Http/Controllers/HomeController.php:15
* @route '/telescope/{view?}'
*/
telescope.url = (args?: { view?: string | number } | [view: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { view: args }
    }

    if (Array.isArray(args)) {
        args = {
            view: args[0],
        }
    }

    args = applyUrlDefaults(args)

    validateParameters(args, [
        "view",
    ])

    const parsedArgs = {
        view: args?.view,
    }

    return telescope.definition.url
            .replace('{view?}', parsedArgs.view?.toString() ?? '')
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Laravel\Telescope\Http\Controllers\HomeController::telescope
* @see vendor/laravel/telescope/src/Http/Controllers/HomeController.php:15
* @route '/telescope/{view?}'
*/
telescope.get = (args?: { view?: string | number } | [view: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: telescope.url(args, options),
    method: 'get',
})

/**
* @see \Laravel\Telescope\Http\Controllers\HomeController::telescope
* @see vendor/laravel/telescope/src/Http/Controllers/HomeController.php:15
* @route '/telescope/{view?}'
*/
telescope.head = (args?: { view?: string | number } | [view: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: telescope.url(args, options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::chatify
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
export const chatify = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: chatify.url(options),
    method: 'get',
})

chatify.definition = {
    methods: ["get","head"],
    url: '/chatify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::chatify
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
chatify.url = (options?: RouteQueryOptions) => {
    return chatify.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::chatify
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
chatify.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: chatify.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::chatify
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
chatify.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: chatify.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::star
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:285
* @route '/chatify/star'
*/
export const star = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: star.url(options),
    method: 'post',
})

star.definition = {
    methods: ["post"],
    url: '/chatify/star',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::star
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:285
* @route '/chatify/star'
*/
star.url = (options?: RouteQueryOptions) => {
    return star.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::star
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:285
* @route '/chatify/star'
*/
star.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: star.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::favorites
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:304
* @route '/chatify/favorites'
*/
export const favorites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorites.url(options),
    method: 'post',
})

favorites.definition = {
    methods: ["post"],
    url: '/chatify/favorites',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::favorites
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:304
* @route '/chatify/favorites'
*/
favorites.url = (options?: RouteQueryOptions) => {
    return favorites.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::favorites
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:304
* @route '/chatify/favorites'
*/
favorites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorites.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
export const search = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

search.definition = {
    methods: ["get","head"],
    url: '/chatify/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
search.url = (options?: RouteQueryOptions) => {
    return search.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
search.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
search.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: search.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::shared
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:360
* @route '/chatify/shared'
*/
export const shared = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: shared.url(options),
    method: 'post',
})

shared.definition = {
    methods: ["post"],
    url: '/chatify/shared',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::shared
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:360
* @route '/chatify/shared'
*/
shared.url = (options?: RouteQueryOptions) => {
    return shared.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::shared
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:360
* @route '/chatify/shared'
*/
shared.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: shared.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::group
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
export const group = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: group.url(args, options),
    method: 'get',
})

group.definition = {
    methods: ["get","head"],
    url: '/chatify/group/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::group
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
group.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return group.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::group
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
group.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: group.url(args, options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::group
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
group.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: group.url(args, options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::user
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
export const user = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: user.url(args, options),
    method: 'get',
})

user.definition = {
    methods: ["get","head"],
    url: '/chatify/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::user
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
user.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return user.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::user
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
user.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: user.url(args, options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::user
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
user.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: user.url(args, options),
    method: 'head',
})

/**
* @see vendor/pxlrbt/filament-excel/routes/web.php:6
* @route '/filament-excel/{path}'
*/
export const filamentExcelDownload = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: filamentExcelDownload.url(args, options),
    method: 'get',
})

filamentExcelDownload.definition = {
    methods: ["get","head"],
    url: '/filament-excel/{path}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see vendor/pxlrbt/filament-excel/routes/web.php:6
* @route '/filament-excel/{path}'
*/
filamentExcelDownload.url = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { path: args }
    }

    if (Array.isArray(args)) {
        args = {
            path: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        path: args.path,
    }

    return filamentExcelDownload.definition.url
            .replace('{path}', parsedArgs.path.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see vendor/pxlrbt/filament-excel/routes/web.php:6
* @route '/filament-excel/{path}'
*/
filamentExcelDownload.get = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: filamentExcelDownload.url(args, options),
    method: 'get',
})

/**
* @see vendor/pxlrbt/filament-excel/routes/web.php:6
* @route '/filament-excel/{path}'
*/
filamentExcelDownload.head = (args: { path: string | number } | [path: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: filamentExcelDownload.url(args, options),
    method: 'head',
})

/**
* @see routes/api.php:397
* @route '/api/idempotency'
*/
export const idempotency = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idempotency.url(options),
    method: 'post',
})

idempotency.definition = {
    methods: ["post"],
    url: '/api/idempotency',
} satisfies RouteDefinition<["post"]>

/**
* @see routes/api.php:397
* @route '/api/idempotency'
*/
idempotency.url = (options?: RouteQueryOptions) => {
    return idempotency.definition.url + queryParams(options)
}

/**
* @see routes/api.php:397
* @route '/api/idempotency'
*/
idempotency.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idempotency.url(options),
    method: 'post',
})

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::login
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:17
* @route '/login'
*/
export const login = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: login.url(options),
    method: 'post',
})

login.definition = {
    methods: ["post"],
    url: '/login',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::login
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:17
* @route '/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::login
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:17
* @route '/login'
*/
login.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: login.url(options),
    method: 'post',
})

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::logout
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:31
* @route '/logout'
*/
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::logout
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:31
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \Modules\Auth\Http\Controllers\AuthenticatedSessionController::logout
* @see modules/auth/src/Http/Controllers/AuthenticatedSessionController.php:31
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

