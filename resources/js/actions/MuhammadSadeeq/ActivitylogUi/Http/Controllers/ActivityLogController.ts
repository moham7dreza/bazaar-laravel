import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::index
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:29
* @route '/activitylog-ui'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivities
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
export const getActivities = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActivities.url(options),
    method: 'get',
})

getActivities.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/activities',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivities
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
getActivities.url = (options?: RouteQueryOptions) => {
    return getActivities.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivities
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
getActivities.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActivities.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivities
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:306
* @route '/activitylog-ui/api/activities'
*/
getActivities.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getActivities.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivity
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
export const getActivity = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActivity.url(args, options),
    method: 'get',
})

getActivity.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/activities/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivity
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
getActivity.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return getActivity.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivity
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
getActivity.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActivity.url(args, options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivity
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:345
* @route '/activitylog-ui/api/activities/{id}'
*/
getActivity.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getActivity.url(args, options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivityRelated
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
export const getActivityRelated = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActivityRelated.url(args, options),
    method: 'get',
})

getActivityRelated.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/activities/{id}/related',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivityRelated
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
getActivityRelated.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return getActivityRelated.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivityRelated
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
getActivityRelated.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getActivityRelated.url(args, options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getActivityRelated
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:368
* @route '/activitylog-ui/api/activities/{id}/related'
*/
getActivityRelated.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getActivityRelated.url(args, options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSearchSuggestions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:392
* @route '/activitylog-ui/api/search/suggestions'
*/
export const getSearchSuggestions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getSearchSuggestions.url(options),
    method: 'get',
})

getSearchSuggestions.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/search/suggestions',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSearchSuggestions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:392
* @route '/activitylog-ui/api/search/suggestions'
*/
getSearchSuggestions.url = (options?: RouteQueryOptions) => {
    return getSearchSuggestions.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSearchSuggestions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:392
* @route '/activitylog-ui/api/search/suggestions'
*/
getSearchSuggestions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getSearchSuggestions.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSearchSuggestions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:392
* @route '/activitylog-ui/api/search/suggestions'
*/
getSearchSuggestions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getSearchSuggestions.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getFilterOptions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
export const getFilterOptions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getFilterOptions.url(options),
    method: 'get',
})

getFilterOptions.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/filter-options',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getFilterOptions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
getFilterOptions.url = (options?: RouteQueryOptions) => {
    return getFilterOptions.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getFilterOptions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
getFilterOptions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getFilterOptions.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getFilterOptions
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:415
* @route '/activitylog-ui/api/filter-options'
*/
getFilterOptions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getFilterOptions.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getEventTypesWithStyling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
export const getEventTypesWithStyling = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getEventTypesWithStyling.url(options),
    method: 'get',
})

getEventTypesWithStyling.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/event-types-styling',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getEventTypesWithStyling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
getEventTypesWithStyling.url = (options?: RouteQueryOptions) => {
    return getEventTypesWithStyling.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getEventTypesWithStyling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
getEventTypesWithStyling.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getEventTypesWithStyling.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getEventTypesWithStyling
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:445
* @route '/activitylog-ui/api/event-types-styling'
*/
getEventTypesWithStyling.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getEventTypesWithStyling.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
export const recent = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recent.url(options),
    method: 'get',
})

recent.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/recent',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
recent.url = (options?: RouteQueryOptions) => {
    return recent.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
recent.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: recent.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::recent
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:288
* @route '/activitylog-ui/api/recent'
*/
recent.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: recent.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
export const analytics = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: analytics.url(options),
    method: 'get',
})

analytics.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/analytics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
analytics.url = (options?: RouteQueryOptions) => {
    return analytics.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
analytics.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: analytics.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::analytics
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:200
* @route '/activitylog-ui/api/analytics'
*/
analytics.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: analytics.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
export const heatmap = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: heatmap.url(options),
    method: 'get',
})

heatmap.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/analytics/heatmap',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
heatmap.url = (options?: RouteQueryOptions) => {
    return heatmap.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
heatmap.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: heatmap.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::heatmap
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:272
* @route '/activitylog-ui/api/analytics/heatmap'
*/
heatmap.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: heatmap.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::userProfile
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:252
* @route '/activitylog-ui/api/users/{userId}/profile'
*/
export const userProfile = (args: { userId: string | number } | [userId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userProfile.url(args, options),
    method: 'get',
})

userProfile.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/users/{userId}/profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::userProfile
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:252
* @route '/activitylog-ui/api/users/{userId}/profile'
*/
userProfile.url = (args: { userId: string | number } | [userId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { userId: args }
    }

    if (Array.isArray(args)) {
        args = {
            userId: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        userId: args.userId,
    }

    return userProfile.definition.url
            .replace('{userId}', parsedArgs.userId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::userProfile
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:252
* @route '/activitylog-ui/api/users/{userId}/profile'
*/
userProfile.get = (args: { userId: string | number } | [userId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: userProfile.url(args, options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::userProfile
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:252
* @route '/activitylog-ui/api/users/{userId}/profile'
*/
userProfile.head = (args: { userId: string | number } | [userId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: userProfile.url(args, options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSavedViews
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:468
* @route '/activitylog-ui/api/views'
*/
export const getSavedViews = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getSavedViews.url(options),
    method: 'get',
})

getSavedViews.definition = {
    methods: ["get","head"],
    url: '/activitylog-ui/api/views',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSavedViews
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:468
* @route '/activitylog-ui/api/views'
*/
getSavedViews.url = (options?: RouteQueryOptions) => {
    return getSavedViews.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSavedViews
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:468
* @route '/activitylog-ui/api/views'
*/
getSavedViews.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: getSavedViews.url(options),
    method: 'get',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::getSavedViews
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:468
* @route '/activitylog-ui/api/views'
*/
getSavedViews.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: getSavedViews.url(options),
    method: 'head',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::saveView
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:139
* @route '/activitylog-ui/api/views'
*/
export const saveView = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: saveView.url(options),
    method: 'post',
})

saveView.definition = {
    methods: ["post"],
    url: '/activitylog-ui/api/views',
} satisfies RouteDefinition<["post"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::saveView
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:139
* @route '/activitylog-ui/api/views'
*/
saveView.url = (options?: RouteQueryOptions) => {
    return saveView.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::saveView
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:139
* @route '/activitylog-ui/api/views'
*/
saveView.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: saveView.url(options),
    method: 'post',
})

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::deleteView
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:171
* @route '/activitylog-ui/api/views'
*/
export const deleteView = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteView.url(options),
    method: 'delete',
})

deleteView.definition = {
    methods: ["delete"],
    url: '/activitylog-ui/api/views',
} satisfies RouteDefinition<["delete"]>

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::deleteView
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:171
* @route '/activitylog-ui/api/views'
*/
deleteView.url = (options?: RouteQueryOptions) => {
    return deleteView.definition.url + queryParams(options)
}

/**
* @see \MuhammadSadeeq\ActivitylogUi\Http\Controllers\ActivityLogController::deleteView
* @see vendor/muhammadsadeeq/laravel-activitylog-ui/src/Http/Controllers/ActivityLogController.php:171
* @route '/activitylog-ui/api/views'
*/
deleteView.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: deleteView.url(options),
    method: 'delete',
})

const ActivityLogController = { index, getActivities, getActivity, getActivityRelated, getSearchSuggestions, getFilterOptions, getEventTypesWithStyling, recent, analytics, heatmap, userProfile, getSavedViews, saveView, deleteView }

export default ActivityLogController