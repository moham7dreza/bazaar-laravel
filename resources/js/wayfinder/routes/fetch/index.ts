import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::messages
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:167
* @route '/chatify/fetchMessages'
*/
export const messages = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: messages.url(options),
    method: 'post',
})

messages.definition = {
    methods: ["post"],
    url: '/chatify/fetchMessages',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::messages
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:167
* @route '/chatify/fetchMessages'
*/
messages.url = (options?: RouteQueryOptions) => {
    return messages.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::messages
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:167
* @route '/chatify/fetchMessages'
*/
messages.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: messages.url(options),
    method: 'post',
})

const fetch = {
    messages: Object.assign(messages, messages),
}

export default fetch