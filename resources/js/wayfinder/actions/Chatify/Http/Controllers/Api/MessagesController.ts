import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\Api\MessagesController::pusherAuth
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:28
* @route '/chatify/api/chat/auth'
*/
export const pusherAuth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pusherAuth.url(options),
    method: 'post',
})

pusherAuth.definition = {
    methods: ["post"],
    url: '/chatify/api/chat/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::pusherAuth
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:28
* @route '/chatify/api/chat/auth'
*/
pusherAuth.url = (options?: RouteQueryOptions) => {
    return pusherAuth.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::pusherAuth
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:28
* @route '/chatify/api/chat/auth'
*/
pusherAuth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pusherAuth.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::idFetchData
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:44
* @route '/chatify/api/idInfo'
*/
export const idFetchData = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idFetchData.url(options),
    method: 'post',
})

idFetchData.definition = {
    methods: ["post"],
    url: '/chatify/api/idInfo',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::idFetchData
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:44
* @route '/chatify/api/idInfo'
*/
idFetchData.url = (options?: RouteQueryOptions) => {
    return idFetchData.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::idFetchData
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:44
* @route '/chatify/api/idInfo'
*/
idFetchData.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idFetchData.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::send
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/chatify/api/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::send
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::send
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:94
* @route '/chatify/api/sendMessage'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::fetch
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:171
* @route '/chatify/api/fetchMessages'
*/
export const fetch = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: fetch.url(options),
    method: 'post',
})

fetch.definition = {
    methods: ["post"],
    url: '/chatify/api/fetchMessages',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::fetch
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:171
* @route '/chatify/api/fetchMessages'
*/
fetch.url = (options?: RouteQueryOptions) => {
    return fetch.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::fetch
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:171
* @route '/chatify/api/fetchMessages'
*/
fetch.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: fetch.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:73
* @route '/chatify/api/download/{fileName}'
*/
export const download = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/chatify/api/download/{fileName}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:73
* @route '/chatify/api/download/{fileName}'
*/
download.url = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { fileName: args }
    }

    if (Array.isArray(args)) {
        args = {
            fileName: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        fileName: args.fileName,
    }

    return download.definition.url
            .replace('{fileName}', parsedArgs.fileName.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:73
* @route '/chatify/api/download/{fileName}'
*/
download.get = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:73
* @route '/chatify/api/download/{fileName}'
*/
download.head = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

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

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
export const getContacts = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getContacts.url(options),
    method: 'get',
})

getContacts.definition = {
    methods: ["get","head"],
    url: '/chatify/api/getContacts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
getContacts.url = (options?: RouteQueryOptions) => {
    return getContacts.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
getContacts.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getContacts.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:208
* @route '/chatify/api/getContacts'
*/
getContacts.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getContacts.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::favorite
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:238
* @route '/chatify/api/star'
*/
export const favorite = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorite.url(options),
    method: 'post',
})

favorite.definition = {
    methods: ["post"],
    url: '/chatify/api/star',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::favorite
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:238
* @route '/chatify/api/star'
*/
favorite.url = (options?: RouteQueryOptions) => {
    return favorite.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::favorite
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:238
* @route '/chatify/api/star'
*/
favorite.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorite.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getFavorites
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:257
* @route '/chatify/api/favorites'
*/
export const getFavorites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getFavorites.url(options),
    method: 'post',
})

getFavorites.definition = {
    methods: ["post"],
    url: '/chatify/api/favorites',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getFavorites
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:257
* @route '/chatify/api/favorites'
*/
getFavorites.url = (options?: RouteQueryOptions) => {
    return getFavorites.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::getFavorites
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:257
* @route '/chatify/api/favorites'
*/
getFavorites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getFavorites.url(options),
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
* @see \Chatify\Http\Controllers\Api\MessagesController::sharedPhotos
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:299
* @route '/chatify/api/shared'
*/
export const sharedPhotos = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sharedPhotos.url(options),
    method: 'post',
})

sharedPhotos.definition = {
    methods: ["post"],
    url: '/chatify/api/shared',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::sharedPhotos
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:299
* @route '/chatify/api/shared'
*/
sharedPhotos.url = (options?: RouteQueryOptions) => {
    return sharedPhotos.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::sharedPhotos
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:299
* @route '/chatify/api/shared'
*/
sharedPhotos.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sharedPhotos.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::deleteConversation
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
export const deleteConversation = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteConversation.url(options),
    method: 'post',
})

deleteConversation.definition = {
    methods: ["post"],
    url: '/chatify/api/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::deleteConversation
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
deleteConversation.url = (options?: RouteQueryOptions) => {
    return deleteConversation.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::deleteConversation
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:318
* @route '/chatify/api/deleteConversation'
*/
deleteConversation.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteConversation.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::updateSettings
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
export const updateSettings = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSettings.url(options),
    method: 'post',
})

updateSettings.definition = {
    methods: ["post"],
    url: '/chatify/api/updateSettings',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::updateSettings
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
updateSettings.url = (options?: RouteQueryOptions) => {
    return updateSettings.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::updateSettings
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:329
* @route '/chatify/api/updateSettings'
*/
updateSettings.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSettings.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::setActiveStatus
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
export const setActiveStatus = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setActiveStatus.url(options),
    method: 'post',
})

setActiveStatus.definition = {
    methods: ["post"],
    url: '/chatify/api/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::setActiveStatus
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
setActiveStatus.url = (options?: RouteQueryOptions) => {
    return setActiveStatus.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\Api\MessagesController::setActiveStatus
* @see vendor/munafio/chatify/src/Http/Controllers/Api/MessagesController.php:392
* @route '/chatify/api/setActiveStatus'
*/
setActiveStatus.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setActiveStatus.url(options),
    method: 'post',
})

const MessagesController = { pusherAuth, idFetchData, send, fetch, download, seen, getContacts, favorite, getFavorites, search, sharedPhotos, deleteConversation, updateSettings, setActiveStatus }

export default MessagesController