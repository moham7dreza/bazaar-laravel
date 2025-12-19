import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
const index0e4dd830ac18c490efef81efeb1c9439 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index0e4dd830ac18c490efef81efeb1c9439.url(options),
    method: 'get',
})

index0e4dd830ac18c490efef81efeb1c9439.definition = {
    methods: ["get","head"],
    url: '/chatify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
index0e4dd830ac18c490efef81efeb1c9439.url = (options?: RouteQueryOptions) => {
    return index0e4dd830ac18c490efef81efeb1c9439.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
index0e4dd830ac18c490efef81efeb1c9439.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index0e4dd830ac18c490efef81efeb1c9439.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify'
*/
index0e4dd830ac18c490efef81efeb1c9439.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index0e4dd830ac18c490efef81efeb1c9439.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
const indexd618846442d9cd60600906c09da627dc = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexd618846442d9cd60600906c09da627dc.url(args, options),
    method: 'get',
})

indexd618846442d9cd60600906c09da627dc.definition = {
    methods: ["get","head"],
    url: '/chatify/group/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
indexd618846442d9cd60600906c09da627dc.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return indexd618846442d9cd60600906c09da627dc.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
indexd618846442d9cd60600906c09da627dc.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: indexd618846442d9cd60600906c09da627dc.url(args, options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/group/{id}'
*/
indexd618846442d9cd60600906c09da627dc.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: indexd618846442d9cd60600906c09da627dc.url(args, options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
const index3bfb0bc9da33ab5b594dc19532f59baa = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index3bfb0bc9da33ab5b594dc19532f59baa.url(args, options),
    method: 'get',
})

index3bfb0bc9da33ab5b594dc19532f59baa.definition = {
    methods: ["get","head"],
    url: '/chatify/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
index3bfb0bc9da33ab5b594dc19532f59baa.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    if (Array.isArray(args)) {
        args = {
            id: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        id: args.id,
    }

    return index3bfb0bc9da33ab5b594dc19532f59baa.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
index3bfb0bc9da33ab5b594dc19532f59baa.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index3bfb0bc9da33ab5b594dc19532f59baa.url(args, options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::index
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:43
* @route '/chatify/{id}'
*/
index3bfb0bc9da33ab5b594dc19532f59baa.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index3bfb0bc9da33ab5b594dc19532f59baa.url(args, options),
    method: 'head',
})

export const index = {
    '/chatify': index0e4dd830ac18c490efef81efeb1c9439,
    '/chatify/group/{id}': indexd618846442d9cd60600906c09da627dc,
    '/chatify/{id}': index3bfb0bc9da33ab5b594dc19532f59baa,
}

/**
* @see \Chatify\Http\Controllers\MessagesController::idFetchData
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:60
* @route '/chatify/idInfo'
*/
export const idFetchData = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idFetchData.url(options),
    method: 'post',
})

idFetchData.definition = {
    methods: ["post"],
    url: '/chatify/idInfo',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::idFetchData
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:60
* @route '/chatify/idInfo'
*/
idFetchData.url = (options?: RouteQueryOptions) => {
    return idFetchData.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::idFetchData
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:60
* @route '/chatify/idInfo'
*/
idFetchData.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: idFetchData.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::send
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:96
* @route '/chatify/sendMessage'
*/
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/chatify/sendMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::send
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:96
* @route '/chatify/sendMessage'
*/
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::send
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:96
* @route '/chatify/sendMessage'
*/
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::fetch
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:167
* @route '/chatify/fetchMessages'
*/
export const fetch = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: fetch.url(options),
    method: 'post',
})

fetch.definition = {
    methods: ["post"],
    url: '/chatify/fetchMessages',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::fetch
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:167
* @route '/chatify/fetchMessages'
*/
fetch.url = (options?: RouteQueryOptions) => {
    return fetch.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::fetch
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:167
* @route '/chatify/fetchMessages'
*/
fetch.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: fetch.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:81
* @route '/chatify/download/{fileName}'
*/
export const download = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/chatify/download/{fileName}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:81
* @route '/chatify/download/{fileName}'
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
* @see \Chatify\Http\Controllers\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:81
* @route '/chatify/download/{fileName}'
*/
download.get = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::download
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:81
* @route '/chatify/download/{fileName}'
*/
download.head = (args: { fileName: string | number } | [fileName: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::pusherAuth
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:27
* @route '/chatify/chat/auth'
*/
export const pusherAuth = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pusherAuth.url(options),
    method: 'post',
})

pusherAuth.definition = {
    methods: ["post"],
    url: '/chatify/chat/auth',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::pusherAuth
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:27
* @route '/chatify/chat/auth'
*/
pusherAuth.url = (options?: RouteQueryOptions) => {
    return pusherAuth.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::pusherAuth
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:27
* @route '/chatify/chat/auth'
*/
pusherAuth.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pusherAuth.url(options),
    method: 'post',
})

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

/**
* @see \Chatify\Http\Controllers\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
export const getContacts = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getContacts.url(options),
    method: 'get',
})

getContacts.definition = {
    methods: ["get","head"],
    url: '/chatify/getContacts',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
getContacts.url = (options?: RouteQueryOptions) => {
    return getContacts.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
getContacts.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getContacts.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::getContacts
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:221
* @route '/chatify/getContacts'
*/
getContacts.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getContacts.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::updateContactItem
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:262
* @route '/chatify/updateContacts'
*/
export const updateContactItem = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateContactItem.url(options),
    method: 'post',
})

updateContactItem.definition = {
    methods: ["post"],
    url: '/chatify/updateContacts',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::updateContactItem
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:262
* @route '/chatify/updateContacts'
*/
updateContactItem.url = (options?: RouteQueryOptions) => {
    return updateContactItem.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::updateContactItem
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:262
* @route '/chatify/updateContacts'
*/
updateContactItem.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateContactItem.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::favorite
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:285
* @route '/chatify/star'
*/
export const favorite = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorite.url(options),
    method: 'post',
})

favorite.definition = {
    methods: ["post"],
    url: '/chatify/star',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::favorite
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:285
* @route '/chatify/star'
*/
favorite.url = (options?: RouteQueryOptions) => {
    return favorite.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::favorite
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:285
* @route '/chatify/star'
*/
favorite.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: favorite.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::getFavorites
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:304
* @route '/chatify/favorites'
*/
export const getFavorites = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getFavorites.url(options),
    method: 'post',
})

getFavorites.definition = {
    methods: ["post"],
    url: '/chatify/favorites',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::getFavorites
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:304
* @route '/chatify/favorites'
*/
getFavorites.url = (options?: RouteQueryOptions) => {
    return getFavorites.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::getFavorites
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:304
* @route '/chatify/favorites'
*/
getFavorites.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: getFavorites.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
export const search = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

search.definition = {
    methods: ["get","head"],
    url: '/chatify/search',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
search.url = (options?: RouteQueryOptions) => {
    return search.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
search.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: search.url(options),
    method: 'get',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::search
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:330
* @route '/chatify/search'
*/
search.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: search.url(options),
    method: 'head',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::sharedPhotos
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:360
* @route '/chatify/shared'
*/
export const sharedPhotos = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sharedPhotos.url(options),
    method: 'post',
})

sharedPhotos.definition = {
    methods: ["post"],
    url: '/chatify/shared',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::sharedPhotos
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:360
* @route '/chatify/shared'
*/
sharedPhotos.url = (options?: RouteQueryOptions) => {
    return sharedPhotos.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::sharedPhotos
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:360
* @route '/chatify/shared'
*/
sharedPhotos.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sharedPhotos.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteConversation
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:384
* @route '/chatify/deleteConversation'
*/
export const deleteConversation = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteConversation.url(options),
    method: 'post',
})

deleteConversation.definition = {
    methods: ["post"],
    url: '/chatify/deleteConversation',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteConversation
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:384
* @route '/chatify/deleteConversation'
*/
deleteConversation.url = (options?: RouteQueryOptions) => {
    return deleteConversation.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteConversation
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:384
* @route '/chatify/deleteConversation'
*/
deleteConversation.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteConversation.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMessage
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:401
* @route '/chatify/deleteMessage'
*/
export const deleteMessage = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMessage.url(options),
    method: 'post',
})

deleteMessage.definition = {
    methods: ["post"],
    url: '/chatify/deleteMessage',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMessage
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:401
* @route '/chatify/deleteMessage'
*/
deleteMessage.url = (options?: RouteQueryOptions) => {
    return deleteMessage.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::deleteMessage
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:401
* @route '/chatify/deleteMessage'
*/
deleteMessage.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deleteMessage.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::updateSettings
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:412
* @route '/chatify/updateSettings'
*/
export const updateSettings = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSettings.url(options),
    method: 'post',
})

updateSettings.definition = {
    methods: ["post"],
    url: '/chatify/updateSettings',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::updateSettings
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:412
* @route '/chatify/updateSettings'
*/
updateSettings.url = (options?: RouteQueryOptions) => {
    return updateSettings.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::updateSettings
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:412
* @route '/chatify/updateSettings'
*/
updateSettings.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateSettings.url(options),
    method: 'post',
})

/**
* @see \Chatify\Http\Controllers\MessagesController::setActiveStatus
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:475
* @route '/chatify/setActiveStatus'
*/
export const setActiveStatus = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setActiveStatus.url(options),
    method: 'post',
})

setActiveStatus.definition = {
    methods: ["post"],
    url: '/chatify/setActiveStatus',
} satisfies RouteDefinition<["post"]>

/**
* @see \Chatify\Http\Controllers\MessagesController::setActiveStatus
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:475
* @route '/chatify/setActiveStatus'
*/
setActiveStatus.url = (options?: RouteQueryOptions) => {
    return setActiveStatus.definition.url + queryParams(options)
}

/**
* @see \Chatify\Http\Controllers\MessagesController::setActiveStatus
* @see vendor/munafio/chatify/src/Http/Controllers/MessagesController.php:475
* @route '/chatify/setActiveStatus'
*/
setActiveStatus.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setActiveStatus.url(options),
    method: 'post',
})

const MessagesController = { index, idFetchData, send, fetch, download, pusherAuth, seen, getContacts, updateContactItem, favorite, getFavorites, search, sharedPhotos, deleteConversation, deleteMessage, updateSettings, setActiveStatus }

export default MessagesController