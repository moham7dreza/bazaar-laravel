import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

deleteMethod.definition = {
    methods: ["post"],
    url: '/chatify/api/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
deleteMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

const conversation = {
    delete: Object.assign(deleteMethod, deleteMethod),
}

export default conversation