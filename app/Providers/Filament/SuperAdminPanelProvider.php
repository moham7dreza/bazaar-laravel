<?php

namespace App\Providers\Filament;

use App\Enums\Language;
use App\Enums\Queue;
use App\Enums\StorageDisk;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SuperAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
//            ->brandName('بازار الان دادااش')
//            ->brandLogo(asset('img/logo.png'))
//            ->brandLogoHeight('2.5rem')
            ->favicon(asset('img/logo.png'))
            ->viteTheme('resources/css/filament/super-admin/theme.css')
            ->spa()
            ->default()
            ->id('super-admin')
            ->path('super-admin')
            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop()
            ->topNavigation(false)
            ->globalSearchKeyBindings(['command+i', 'ctrl+i'])
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
//            ->profile()
            ->authGuard('web')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                \Cmsmaxinc\FilamentSystemVersions\Filament\Widgets\DependencyWidget::make(),
                \Awcodes\Overlook\Widgets\OverlookWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->plugins([
                \Hasnayeen\Themes\ThemesPlugin::make(),
                \ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPolingInterval('10s')
                    ->usingQueue(Queue::BACKUP->value)
                    ->noTimeout(),
                \pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin::make()
                    ->visible(fn () => auth()->user()?->isAdmin())
                    ->showGitBranch(),
                \Rmsramos\Activitylog\ActivitylogPlugin::make(),
                \CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin::make(),
                \Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin::make(),
                \Mvenghaus\FilamentScheduleMonitor\FilamentPlugin::make(),
                \Vormkracht10\FilamentMails\FilamentMailsPlugin::make(),
                \TomatoPHP\FilamentPWA\FilamentPWAPlugin::make(),
                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterNavigation: true,
                        hasAvatars: true,
                    )
                    ->avatarUploadComponent(fn () => FileUpload::make('avatar_url')->disk(StorageDisk::PUBLIC->value))
                    ->enableTwoFactorAuthentication()
                    ->enableSanctumTokens(),
                \pxlrbt\FilamentSpotlight\SpotlightPlugin::make(),
                \Awcodes\Overlook\OverlookPlugin::make()
                    ->sort(2)
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                        'md' => 3,
                        'lg' => 4,
                        'xl' => 5,
                        '2xl' => null,
                    ]),
                \Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin::make(),
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                \Kenepa\ResourceLock\ResourceLockPlugin::make(),
                \Afsakar\FilamentOtpLogin\FilamentOtpLoginPlugin::make(),
                \Statikbe\FilamentTranslationManager\FilamentChainedTranslationManagerPlugin::make(),
                \TomatoPHP\FilamentMediaManager\FilamentMediaManagerPlugin::make(),
                \GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin::make()
                    ->navigationGroup('Settings')
                    ->navigationIcon('heroicon-o-cog-8-tooth'),
            ])
            ->routes(fn () => \Vormkracht10\FilamentMails\Facades\FilamentMails::routes())
            ->navigationItems($this->getNavItems());
    }

    public function boot(): void
    {
        LanguageSwitch::configureUsing(static function (LanguageSwitch $switch) {
            $switch
                ->locales(Language::values());
        });

        \Statikbe\FilamentTranslationManager\FilamentTranslationManager::setLocales(Language::values());
    }

    private function getNavItems(): array
    {
        return collect(config('tools'))->except('backend-admin')
            ->map(fn (array $tool) => NavigationItem::make()
                ->label(fn (): string => trans($tool['title']))
                ->url($tool['url'], shouldOpenInNewTab: false)
                ->icon($tool['heroicon'])
                ->group($tool['group'])
                ->sort($tool['sort'])
            )
            ->all();
    }
}
