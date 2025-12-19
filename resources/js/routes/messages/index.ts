import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::seen
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:205
* @route '/chatify/makeSeen'
*/
export const seen = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

seen.definition = {
    methods: ["post"],
    url: '/chatify/makeSeen',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::seen
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:205
* @route '/chatify/makeSeen'
*/
seen.url = (options?: RouteQueryOptions) => {
    return seen.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::seen
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:205
* @route '/chatify/makeSeen'
*/
seen.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

const messages = {
    seen: Object.assign(seen, seen),
}

export default messages