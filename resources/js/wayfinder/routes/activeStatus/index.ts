import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::set
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:475
* @route '/chatify/setActiveStatus'
*/
export const set = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

set.definition = {
    methods: ["post"],
    url: '/chatify/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::set
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:475
* @route '/chatify/setActiveStatus'
*/
set.url = (options?: RouteQueryOptions) => {
    return set.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::set
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:475
* @route '/chatify/setActiveStatus'
*/
set.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: set.url(options),
    method: 'post',
})

const activeStatus = {
    set: Object.assign(set, set),
}

export default activeStatus