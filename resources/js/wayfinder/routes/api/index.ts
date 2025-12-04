import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
import payment from './payment'
import pusher from './pusher'
import send from './send'
import fetch from './fetch'
import attachments from './attachments'
import messages from './messages'
import contacts from './contacts'
import conversation from './conversation'
import avatar from './avatar'
import activeStatus from './activeStatus'
import user from './user'
import auth from './auth'
import categories from './categories'
import menus from './menus'
import pages from './pages'
import states from './states'
import cities from './cities'
import advertisements from './advertisements'
import images from './images'
import admin from './admin'
import panel from './panel'
import today from './today'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::idInfo
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:44
* @route '/chatify/api/idInfo'
*/
export const idInfo = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idInfo.url(options),
    method: 'post',
})

idInfo.definition = {
    methods: ["post"],
    url: '/chatify/api/idInfo',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::idInfo
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:44
* @route '/chatify/api/idInfo'
*/
idInfo.url = (options?: RouteQueryOptions) => {
    return idInfo.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::idInfo
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:44
* @route '/chatify/api/idInfo'
*/
idInfo.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idInfo.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::star
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:238
* @route '/chatify/api/star'
*/
export const star = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: star.url(options),
    method: 'post',
})

star.definition = {
    methods: ["post"],
    url: '/chatify/api/star',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::star
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:238
* @route '/chatify/api/star'
*/
star.url = (options?: RouteQueryOptions) => {
    return star.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::star
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:238
* @route '/chatify/api/star'
*/
star.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: star.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::favorites
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:257
* @route '/chatify/api/favorites'
*/
export const favorites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorites.url(options),
    method: 'post',
})

favorites.definition = {
    methods: ["post"],
    url: '/chatify/api/favorites',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::favorites
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:257
* @route '/chatify/api/favorites'
*/
favorites.url = (options?: RouteQueryOptions) => {
    return favorites.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::favorites
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:257
* @route '/chatify/api/favorites'
*/
favorites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorites.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:275
* @route '/chatify/api/search'
*/
export const search = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

search.definition = {
    methods: ["get","head"],
    url: '/chatify/api/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:275
* @route '/chatify/api/search'
*/
search.url = (options?: RouteQueryOptions) => {
    return search.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:275
* @route '/chatify/api/search'
*/
search.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:275
* @route '/chatify/api/search'
*/
search.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: search.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::shared
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:299
* @route '/chatify/api/shared'
*/
export const shared = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: shared.url(options),
    method: 'post',
})

shared.definition = {
    methods: ["post"],
    url: '/chatify/api/shared',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::shared
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:299
* @route '/chatify/api/shared'
*/
shared.url = (options?: RouteQueryOptions) => {
    return shared.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::shared
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:299
* @route '/chatify/api/shared'
*/
shared.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: shared.url(options),
    method: 'post',
})

const api = {
    payment: Object.assign(payment, payment),
    pusher: Object.assign(pusher, pusher),
    idInfo: Object.assign(idInfo, idInfo),
    send: Object.assign(send, send),
    fetch: Object.assign(fetch, fetch),
    attachments: Object.assign(attachments, attachments),
    messages: Object.assign(messages, messages),
    contacts: Object.assign(contacts, contacts),
    star: Object.assign(star, star),
    favorites: Object.assign(favorites, favorites),
    search: Object.assign(search, search),
    shared: Object.assign(shared, shared),
    conversation: Object.assign(conversation, conversation),
    avatar: Object.assign(avatar, avatar),
    activeStatus: Object.assign(activeStatus, activeStatus),
    user: Object.assign(user, user),
    auth: Object.assign(auth, auth),
    categories: Object.assign(categories, categories),
    menus: Object.assign(menus, menus),
    pages: Object.assign(pages, pages),
    states: Object.assign(states, states),
    cities: Object.assign(cities, cities),
    advertisements: Object.assign(advertisements, advertisements),
    images: Object.assign(images, images),
    admin: Object.assign(admin, admin),
    panel: Object.assign(panel, panel),
    today: Object.assign(today, today),
}

export default api