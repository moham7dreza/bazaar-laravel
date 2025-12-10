import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::update
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/chatify/api/updateSettings',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::update
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::update
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

const avatar = {
    update: Object.assign(update, update),
}

export default avatar