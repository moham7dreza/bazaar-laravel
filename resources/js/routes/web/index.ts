import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import permissions from './permissions'
import image from './image'
/**
* @see \App\Http\Controllers\HomeController::__invoke
* @see app/Http/Controllers/HomeController.php:14
* @route '/'
*/
export const welcome = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})

welcome.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\HomeController::__invoke
* @see app/Http/Controllers/HomeController.php:14
* @route '/'
*/
welcome.url = (options?: RouteQueryOptions) => {
    return welcome.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HomeController::__invoke
* @see app/Http/Controllers/HomeController.php:14
* @route '/'
*/
welcome.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: welcome.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\HomeController::__invoke
* @see app/Http/Controllers/HomeController.php:14
* @route '/'
*/
welcome.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: welcome.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/tool'
*/
export const tool = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tool.url(options),
    method: 'get',
})

tool.definition = {
    methods: ["get","head"],
    url: '/tool',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/tool'
*/
tool.url = (options?: RouteQueryOptions) => {
    return tool.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/tool'
*/
tool.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: tool.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\ViewController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/ViewController.php:32
* @route '/tool'
*/
tool.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: tool.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
export const domainRouter = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: domainRouter.url(options),
    method: 'get',
})

domainRouter.definition = {
    methods: ["get","head"],
    url: '/domain-router',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
domainRouter.url = (options?: RouteQueryOptions) => {
    return domainRouter.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
domainRouter.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: domainRouter.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\DomainRouterController::__invoke
* @see app/Http/Controllers/DomainRouterController.php:13
* @route '/domain-router'
*/
domainRouter.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: domainRouter.url(options),
    method: 'head',
})

/**
* @see routes/web.php:41
* @route '/run-scheduler/{token}'
*/
export const runScheduler = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: runScheduler.url(args, options),
    method: 'get',
})

runScheduler.definition = {
    methods: ["get","head"],
    url: '/run-scheduler/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/web.php:41
* @route '/run-scheduler/{token}'
*/
runScheduler.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        token: args.token,
    }

    return runScheduler.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/web.php:41
* @route '/run-scheduler/{token}'
*/
runScheduler.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: runScheduler.url(args, options),
    method: 'get',
})

/**
* @see routes/web.php:41
* @route '/run-scheduler/{token}'
*/
runScheduler.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: runScheduler.url(args, options),
    method: 'head',
})

const web = {
    welcome: Object.assign(welcome, welcome),
    tool: Object.assign(tool, tool),
    permissions: Object.assign(permissions, permissions),
    domainRouter: Object.assign(domainRouter, domainRouter),
    image: Object.assign(image, image),
    runScheduler: Object.assign(runScheduler, runScheduler),
}

export default web