<?php

declare(strict_types=1);

namespace Modules\Filament\Providers;

use Afsakar\FilamentOtpLogin\FilamentOtpLoginPlugin;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Enums\ClientLocale;
use App\Enums\Disk;
use App\Enums\Queue;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Brickx\MaintenanceSwitch\MaintenanceSwitchPlugin;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use Cmsmaxinc\FilamentSystemVersions\Filament\Widgets\DependencyWidget;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Tables\Table;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Arr;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Kenepa\ResourceLock\ResourceLockPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Modules\Filament\Resources\UserResource;
use Mvenghaus\FilamentScheduleMonitor\FilamentPlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Rmsramos\Activitylog\ActivitylogPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use Statikbe\FilamentTranslationManager\FilamentChainedTranslationManagerPlugin;
use Statikbe\FilamentTranslationManager\FilamentTranslationManager;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use TomatoPHP\FilamentMediaManager\FilamentMediaManagerPlugin;
use TomatoPHP\FilamentPWA\FilamentPWAPlugin;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use Vormkracht10\FilamentMails\FilamentMailsPlugin;

final class SuperAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
//            ->brandName('بازار')
//            ->brandLogo(asset('images/logo.png'))
//            ->brandLogoHeight('2.5rem')
            ->favicon(asset('images/logo.png'))
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
            ->discoverResources(in: base_path('modules/filament/src/Resources'), for: 'Modules\\Filament\\Resources')
            ->discoverPages(in: base_path('modules/filament/src/Pages'), for: 'Modules\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: base_path('modules/filament/src/Widgets'), for: 'Modules\\Filament\\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
                DependencyWidget::make(),
                OverlookWidget::class,
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
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->plugins([
                ThemesPlugin::make(),
                FilamentSpatieLaravelBackupPlugin::make()
                    ->usingPolingInterval('10s')
                    ->usingQueue(Queue::Backup->value)
                    ->noTimeout(),
                EnvironmentIndicatorPlugin::make()
                    ->visible(fn () => auth()->user()?->isAdmin())
                    ->showGitBranch(),
                ActivitylogPlugin::make(),
                GlobalSearchModalPlugin::make(),
                FilamentSpatieRolesPermissionsPlugin::make(),
                FilamentPlugin::make(),
                FilamentMailsPlugin::make(),
                FilamentPWAPlugin::make(),
                BreezyCore::make()
                    ->myProfile(
                        shouldRegisterNavigation: true,
                        hasAvatars: true,
                    )
                    ->avatarUploadComponent(
                        fn (): FileUpload => FileUpload::make('avatar_url')
                            ->disk(Disk::Public->value)
                    )
                    ->enableTwoFactorAuthentication()
                    ->enableSanctumTokens(),
                SpotlightPlugin::make(),
                OverlookPlugin::make()
                    ->sort(2)
                    ->columns([
                        'default' => 1,
                        'sm'      => 2,
                        'md'      => 3,
                        'lg'      => 4,
                        'xl'      => 5,
                        '2xl'     => null,
                    ]),
                FilamentApexChartsPlugin::make(),
                FilamentExceptionsPlugin::make(),
                ResourceLockPlugin::make(),
                FilamentOtpLoginPlugin::make(),
                FilamentChainedTranslationManagerPlugin::make(),
                FilamentMediaManagerPlugin::make(),
                FilamentEnvEditorPlugin::make()
                    ->navigationGroup('Settings')
                    ->navigationIcon('heroicon-o-cog-8-tooth'),
                MaintenanceSwitchPlugin::make(),
                FilamentBackgroundsPlugin::make(),
                QuickCreatePlugin::make()
                    ->slideOver()
                    ->keyBindings(['command+shift+a', 'ctrl+shift+a'])
                    ->includes([
                        UserResource::class,
                    ]),
                FilamentErrorPagesPlugin::make(),
            ])
            ->routes(fn () => FilamentMails::routes())
            ->navigationItems($this->getNavItems());
    }

    public function boot(): void
    {
        $this->configureLanguageSwitch();

        FilamentTranslationManager::setLocales(ClientLocale::values());

        $this->configureTable();
    }

    private function configureTable(): void
    {
        Table::configureUsing(static fn (Table $table): bool => $table
            ->striped()
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistsSortInSession());
    }

    private function configureLanguageSwitch(): void
    {
        LanguageSwitch::configureUsing(static function (LanguageSwitch $switch): void {
            $switch
                ->locales(ClientLocale::values());
        });
    }

    private function getNavItems(): array
    {
        return once(
            fn () => collect(config('tools'))->except('backend-admin')
                ->map(
                    fn (array $tool): NavigationItem => NavigationItem::make()
                        ->label(fn (): string => trans(Arr::get($tool, 'title')))
                        ->url(Arr::get($tool, 'url'), shouldOpenInNewTab: true)
                        ->icon(Arr::get($tool, 'heroicon'))
                        ->group(Arr::get($tool, 'group'))
                        ->sort(Arr::get($tool, 'sort'))
                )
                ->all()
        );
    }
}
