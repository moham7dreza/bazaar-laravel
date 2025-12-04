import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
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

const attachments = {
    download: Object.assign(download, download),
}

export default attachments