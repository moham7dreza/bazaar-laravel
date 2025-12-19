import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/super-admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Filament\Pages\Dashboard::__invoke
* @see vendor/filament/filament/src/Pages/Dashboard.php:7
* @route '/super-admin'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
export const themes = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: themes.url(options),
    method: 'get',
})

themes.definition = {
    methods: ["get","head"],
    url: '/super-admin/themes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
themes.url = (options?: RouteQueryOptions) => {
    return themes.definition.url + queryParams(options)
}

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
themes.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: themes.url(options),
    method: 'get',
})

/**
* @see \Hasnayeen\Themes\Filament\Pages\Themes::__invoke
* @see vendor/hasnayeen/themes/src/Filament/Pages/Themes.php:7
* @route '/super-admin/themes'
*/
themes.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: themes.url(options),
    method: 'head',
})

/**
* @see \ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups::__invoke
* @see vendor/shuvroroy/filament-spatie-laravel-backup/src/Pages/Backups.php:7
* @route '/super-admin/backups'
*/
export const backups = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: backups.url(options),
    method: 'get',
})

backups.definition = {
    methods: ["get","head"],
    url: '/super-admin/backups',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups::__invoke
* @see vendor/shuvroroy/filament-spatie-laravel-backup/src/Pages/Backups.php:7
* @route '/super-admin/backups'
*/
backups.url = (options?: RouteQueryOptions) => {
    return backups.definition.url + queryParams(options)
}

/**
* @see \ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups::__invoke
* @see vendor/shuvroroy/filament-spatie-laravel-backup/src/Pages/Backups.php:7
* @route '/super-admin/backups'
*/
backups.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: backups.url(options),
    method: 'get',
})

/**
* @see \ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups::__invoke
* @see vendor/shuvroroy/filament-spatie-laravel-backup/src/Pages/Backups.php:7
* @route '/super-admin/backups'
*/
backups.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: backups.url(options),
    method: 'head',
})

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
export const pwaSettingsPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pwaSettingsPage.url(options),
    method: 'get',
})

pwaSettingsPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/pwa-settings-page',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
pwaSettingsPage.url = (options?: RouteQueryOptions) => {
    return pwaSettingsPage.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
pwaSettingsPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pwaSettingsPage.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentPWA\Filament\Pages\PWASettingsPage::__invoke
* @see vendor/tomatophp/filament-pwa/src/Filament/Pages/PWASettingsPage.php:7
* @route '/super-admin/pwa-settings-page'
*/
pwaSettingsPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pwaSettingsPage.url(options),
    method: 'head',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
export const siteSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: siteSettings.url(options),
    method: 'get',
})

siteSettings.definition = {
    methods: ["get","head"],
    url: '/super-admin/site-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
siteSettings.url = (options?: RouteQueryOptions) => {
    return siteSettings.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
siteSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: siteSettings.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SiteSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SiteSettings.php:7
* @route '/super-admin/site-settings'
*/
siteSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: siteSettings.url(options),
    method: 'head',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
export const socialMenuSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: socialMenuSettings.url(options),
    method: 'get',
})

socialMenuSettings.definition = {
    methods: ["get","head"],
    url: '/super-admin/social-menu-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
socialMenuSettings.url = (options?: RouteQueryOptions) => {
    return socialMenuSettings.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
socialMenuSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: socialMenuSettings.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SocialMenuSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SocialMenuSettings.php:7
* @route '/super-admin/social-menu-settings'
*/
socialMenuSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: socialMenuSettings.url(options),
    method: 'head',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
export const locationSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: locationSettings.url(options),
    method: 'get',
})

locationSettings.definition = {
    methods: ["get","head"],
    url: '/super-admin/location-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
locationSettings.url = (options?: RouteQueryOptions) => {
    return locationSettings.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
locationSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: locationSettings.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\LocationSettings::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/LocationSettings.php:7
* @route '/super-admin/location-settings'
*/
locationSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: locationSettings.url(options),
    method: 'head',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
export const settingsHub = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settingsHub.url(options),
    method: 'get',
})

settingsHub.definition = {
    methods: ["get","head"],
    url: '/super-admin/settings-hub',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
settingsHub.url = (options?: RouteQueryOptions) => {
    return settingsHub.definition.url + queryParams(options)
}

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
settingsHub.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: settingsHub.url(options),
    method: 'get',
})

/**
* @see \TomatoPHP\FilamentSettingsHub\Pages\SettingsHub::__invoke
* @see vendor/tomatophp/filament-settings-hub/src/Pages/SettingsHub.php:7
* @route '/super-admin/settings-hub'
*/
settingsHub.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: settingsHub.url(options),
    method: 'head',
})

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
export const myProfile = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: myProfile.url(options),
    method: 'get',
})

myProfile.definition = {
    methods: ["get","head"],
    url: '/super-admin/my-profile',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
myProfile.url = (options?: RouteQueryOptions) => {
    return myProfile.definition.url + queryParams(options)
}

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
myProfile.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: myProfile.url(options),
    method: 'get',
})

/**
* @see \Jeffgreco13\FilamentBreezy\Pages\MyProfilePage::__invoke
* @see vendor/jeffgreco13/filament-breezy/src/Pages/MyProfilePage.php:7
* @route '/super-admin/my-profile'
*/
myProfile.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: myProfile.url(options),
    method: 'head',
})

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
export const translationManagerPage = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: translationManagerPage.url(options),
    method: 'get',
})

translationManagerPage.definition = {
    methods: ["get","head"],
    url: '/super-admin/translation-manager-page',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
translationManagerPage.url = (options?: RouteQueryOptions) => {
    return translationManagerPage.definition.url + queryParams(options)
}

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
translationManagerPage.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: translationManagerPage.url(options),
    method: 'get',
})

/**
* @see \Statikbe\FilamentTranslationManager\Pages\TranslationManagerPage::__invoke
* @see vendor/statikbe/laravel-filament-chained-translation-manager/src/Pages/TranslationManagerPage.php:7
* @route '/super-admin/translation-manager-page'
*/
translationManagerPage.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: translationManagerPage.url(options),
    method: 'head',
})

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
export const envEditor = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: envEditor.url(options),
    method: 'get',
})

envEditor.definition = {
    methods: ["get","head"],
    url: '/super-admin/env-editor',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
envEditor.url = (options?: RouteQueryOptions) => {
    return envEditor.definition.url + queryParams(options)
}

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
envEditor.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: envEditor.url(options),
    method: 'get',
})

/**
* @see \GeoSot\FilamentEnvEditor\Pages\ViewEnv::__invoke
* @see vendor/geo-sot/filament-env-editor/src/Pages/ViewEnv.php:7
* @route '/super-admin/env-editor'
*/
envEditor.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: envEditor.url(options),
    method: 'head',
})

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
export const method404 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: method404.url(options),
    method: 'get',
})

method404.definition = {
    methods: ["get","head"],
    url: '/super-admin/404',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
method404.url = (options?: RouteQueryOptions) => {
    return method404.definition.url + queryParams(options)
}

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
method404.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: method404.url(options),
    method: 'get',
})

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\PageNotFoundPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/PageNotFoundPage.php:7
* @route '/super-admin/404'
*/
method404.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: method404.url(options),
    method: 'head',
})

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
export const method403 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: method403.url(options),
    method: 'get',
})

method403.definition = {
    methods: ["get","head"],
    url: '/super-admin/403',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
method403.url = (options?: RouteQueryOptions) => {
    return method403.definition.url + queryParams(options)
}

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
method403.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: method403.url(options),
    method: 'get',
})

/**
* @see \Cmsmaxinc\FilamentErrorPages\Filament\Pages\ForbiddenPage::__invoke
* @see vendor/cmsmaxinc/filament-error-pages/src/Filament/Pages/ForbiddenPage.php:7
* @route '/super-admin/403'
*/
method403.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: method403.url(options),
    method: 'head',
})

const pages = {
    dashboard: Object.assign(dashboard, dashboard),
    themes: Object.assign(themes, themes),
    backups: Object.assign(backups, backups),
    pwaSettingsPage: Object.assign(pwaSettingsPage, pwaSettingsPage),
    siteSettings: Object.assign(siteSettings, siteSettings),
    socialMenuSettings: Object.assign(socialMenuSettings, socialMenuSettings),
    locationSettings: Object.assign(locationSettings, locationSettings),
    settingsHub: Object.assign(settingsHub, settingsHub),
    myProfile: Object.assign(myProfile, myProfile),
    translationManagerPage: Object.assign(translationManagerPage, translationManagerPage),
    envEditor: Object.assign(envEditor, envEditor),
    404: Object.assign(method404, method404),
    403: Object.assign(method403, method403),
}

export default pages