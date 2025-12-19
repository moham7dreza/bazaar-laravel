import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:401
* @route '/chatify/deleteMessage'
*/
export const deleteMethod = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

deleteMethod.definition = {
    methods: ["post"],
    url: '/chatify/deleteMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:401
* @route '/chatify/deleteMessage'
*/
deleteMethod.url = (options?: RouteQueryOptions) => {
    return deleteMethod.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMethod
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:401
* @route '/chatify/deleteMessage'
*/
deleteMethod.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMethod.url(options),
    method: 'post',
})

const message = {
    delete: Object.assign(deleteMethod, deleteMethod),
}

export default message