import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::auth
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:27
* @route '/chatify/chat/auth'
*/
export const auth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

auth.definition = {
    methods: ["post"],
    url: '/chatify/chat/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::auth
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:27
* @route '/chatify/chat/auth'
*/
auth.url = (options?: RouteQueryOptions) => {
    return auth.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::auth
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:27
* @route '/chatify/chat/auth'
*/
auth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: auth.url(options),
    method: 'post',
})

const pusher = {
    auth: Object.assign(auth, auth),
}

export default pusher