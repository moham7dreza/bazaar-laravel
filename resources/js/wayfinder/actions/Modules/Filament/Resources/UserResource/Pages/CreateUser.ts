import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \Modules\Filament\Resources\UserResource\Pages\CreateUser::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/CreateUser.php:7
* @route '/super-admin/users/create'
*/
const CreateUser = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateUser.url(options),
    method: 'get',
})

CreateUser.definition = {
    methods: ["get","head"],
    url: '/super-admin/users/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Modules\Filament\Resources\UserResource\Pages\CreateUser::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/CreateUser.php:7
* @route '/super-admin/users/create'
*/
CreateUser.url = (options?: RouteQueryOptions) => {
    return CreateUser.definition.url + queryParams(options)
}

/**
* @see \Modules\Filament\Resources\UserResource\Pages\CreateUser::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/CreateUser.php:7
* @route '/super-admin/users/create'
*/
CreateUser.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateUser.url(options),
    method: 'get',
})

/**
* @see \Modules\Filament\Resources\UserResource\Pages\CreateUser::__invoke
* @see modules/filament/src/Resources/UserResource/Pages/CreateUser.php:7
* @route '/super-admin/users/create'
*/
CreateUser.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateUser.url(options),
    method: 'head',
})

export default CreateUser