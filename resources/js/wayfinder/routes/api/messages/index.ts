import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::seen
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:192
* @route '/chatify/api/makeSeen'
*/
export const seen = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

seen.definition = {
    methods: ["post"],
    url: '/chatify/api/makeSeen',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::seen
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:192
* @route '/chatify/api/makeSeen'
*/
seen.url = (options?: RouteQueryOptions) => {
    return seen.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::seen
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:192
* @route '/chatify/api/makeSeen'
*/
seen.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: seen.url(options),
    method: 'post',
})

const messages = {
    seen: Object.assign(seen, seen),
}

export default messages