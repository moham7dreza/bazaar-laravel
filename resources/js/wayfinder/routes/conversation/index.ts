import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:384
* @route '/chatify/deleteConversation'
*/
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

deleteMethod.definition = {
    methods: ["post"],
    url: '/chatify/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:384
* @route '/chatify/deleteConversation'
*/
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:384
* @route '/chatify/deleteConversation'
*/
deleteMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

const conversation = {
    delete: Object.assign(deleteMethod, deleteMethod),
}

export default conversation