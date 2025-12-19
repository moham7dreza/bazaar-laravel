import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::message
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:96
* @route '/chatify/sendMessage'
*/
export const message = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

message.definition = {
    methods: ["post"],
    url: '/chatify/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::message
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:96
* @route '/chatify/sendMessage'
*/
message.url = (options?: RouteQueryOptions) => {
    return message.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::message
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:96
* @route '/chatify/sendMessage'
*/
message.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

const send = {
    message: Object.assign(message, message),
}

export default send