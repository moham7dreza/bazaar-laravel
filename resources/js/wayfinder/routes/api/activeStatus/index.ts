import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::set
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
export const set = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

set.definition = {
    methods: ["post"],
    url: '/chatify/api/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::set
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
set.url = (options?: RouteQueryOptions) => {
    return set.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::set
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
set.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

const activeStatus = {
    set: Object.assign(set, set),
}

export default activeStatus