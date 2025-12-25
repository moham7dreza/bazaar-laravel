import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see routes/api.php:422
* @route '/api/today/{date}'
*/
export const date = (args: { date: string | number } | [date: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: date.url(args, options),
    method: 'get',
})

date.definition = {
    methods: ["get","head"],
    url: '/api/today/{date}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see routes/api.php:422
* @route '/api/today/{date}'
*/
date.url = (args: { date: string | number } | [date: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { date: args }
    }

    if (Array.isArray(args)) {
        args = {
            date: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        date: args.date,
    }

    return date.definition.url
            .replace('{date}', parsedArgs.date.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see routes/api.php:422
* @route '/api/today/{date}'
*/
date.get = (args: { date: string | number } | [date: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: date.url(args, options),
    method: 'get',
})

/**
* @see routes/api.php:422
* @route '/api/today/{date}'
*/
date.head = (args: { date: string | number } | [date: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: date.url(args, options),
    method: 'head',
})

const today = {
    date: Object.assign(date, date),
}

export default today