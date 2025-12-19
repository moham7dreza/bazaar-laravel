import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::get
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
export const get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get.url(options),
    method: 'get',
})

get.definition = {
    methods: ["get","head"],
    url: '/chatify/getContacts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::get
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
get.url = (options?: RouteQueryOptions) => {
    return get.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::get
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
get.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: get.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::get
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
get.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: get.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::update
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:262
* @route '/chatify/updateContacts'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

update.definition = {
    methods: ["post"],
    url: '/chatify/updateContacts',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::update
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:262
* @route '/chatify/updateContacts'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::update
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:262
* @route '/chatify/updateContacts'
*/
update.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: update.url(options),
    method: 'post',
})

const contacts = {
    get: Object.assign(get, get),
    update: Object.assign(update, update),
}

export default contacts