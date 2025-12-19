import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::message
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
export const message = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

message.definition = {
    methods: ["post"],
    url: '/chatify/api/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::message
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
message.url = (options?: RouteQueryOptions) => {
    return message.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::message
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
message.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: message.url(options),
    method: 'post',
})

const send = {
    message: Object.assign(message, message),
}

export default send