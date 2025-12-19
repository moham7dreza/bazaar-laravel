import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveKavenegar
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:20
* @route '/amiriun-sms/kavenegar/receive'
*/
export const receiveKavenegar = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: receiveKavenegar.url(options),
    method: 'post',
})

receiveKavenegar.definition = {
    methods: ["post"],
    url: '/amiriun-sms/kavenegar/receive',
} satisfies RouteDefinition<["post"]>

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveKavenegar
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:20
* @route '/amiriun-sms/kavenegar/receive'
*/
receiveKavenegar.url = (options?: RouteQueryOptions) => {
    return receiveKavenegar.definition.url + queryParams(options)
}

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveKavenegar
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:20
* @route '/amiriun-sms/kavenegar/receive'
*/
receiveKavenegar.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: receiveKavenegar.url(options),
    method: 'post',
})

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverKavenegar
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:35
* @route '/amiriun-sms/kavenegar/deliver'
*/
export const deliverKavenegar = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deliverKavenegar.url(options),
    method: 'post',
})

deliverKavenegar.definition = {
    methods: ["post"],
    url: '/amiriun-sms/kavenegar/deliver',
} satisfies RouteDefinition<["post"]>

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverKavenegar
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:35
* @route '/amiriun-sms/kavenegar/deliver'
*/
deliverKavenegar.url = (options?: RouteQueryOptions) => {
    return deliverKavenegar.definition.url + queryParams(options)
}

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverKavenegar
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:35
* @route '/amiriun-sms/kavenegar/deliver'
*/
deliverKavenegar.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: deliverKavenegar.url(options),
    method: 'post',
})

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:46
* @route '/amiriun-sms/mediana/receive'
*/
export const receiveMediana = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: receiveMediana.url(options),
    method: 'get',
})

receiveMediana.definition = {
    methods: ["get","head"],
    url: '/amiriun-sms/mediana/receive',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:46
* @route '/amiriun-sms/mediana/receive'
*/
receiveMediana.url = (options?: RouteQueryOptions) => {
    return receiveMediana.definition.url + queryParams(options)
}

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:46
* @route '/amiriun-sms/mediana/receive'
*/
receiveMediana.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: receiveMediana.url(options),
    method: 'get',
})

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::receiveMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:46
* @route '/amiriun-sms/mediana/receive'
*/
receiveMediana.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: receiveMediana.url(options),
    method: 'head',
})

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:60
* @route '/amiriun-sms/mediana/deliver'
*/
export const deliverMediana = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deliverMediana.url(options),
    method: 'get',
})

deliverMediana.definition = {
    methods: ["get","head"],
    url: '/amiriun-sms/mediana/deliver',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:60
* @route '/amiriun-sms/mediana/deliver'
*/
deliverMediana.url = (options?: RouteQueryOptions) => {
    return deliverMediana.definition.url + queryParams(options)
}

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:60
* @route '/amiriun-sms/mediana/deliver'
*/
deliverMediana.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: deliverMediana.url(options),
    method: 'get',
})

/**
* @see \Amiriun\SMS\Http\Controllers\HookController::deliverMediana
* @see vendor/amiriun/sms/src/Http/Controllers/HookController.php:60
* @route '/amiriun-sms/mediana/deliver'
*/
deliverMediana.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: deliverMediana.url(options),
    method: 'head',
})

const HookController = { receiveKavenegar, deliverKavenegar, receiveMediana, deliverMediana }

export default HookController