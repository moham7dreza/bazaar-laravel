<?php

declare(strict_types=1);

namespace Modules\Filament\Providers;

use Filament\Pages\Dashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Cmsmaxinc\FilamentSystemVersions\Filament\Widgets\DependencyWidget;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;
use Rmsramos\Activitylog\ActivitylogPlugin;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use Mvenghaus\FilamentScheduleMonitor\FilamentPlugin;
use Vormkracht10\FilamentMails\FilamentMailsPlugin;
use TomatoPHP\FilamentPWA\FilamentPWAPlugin;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Awcodes\Overlook\OverlookPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin;
use Kenepa\ResourceLock\ResourceLockPlugin;
use Afsakar\FilamentOtpLogin\FilamentOtpLoginPlugin;
use Statikbe\FilamentTranslationManager\FilamentChainedTranslationManagerPlugin;
use TomatoPHP\FilamentMediaManager\FilamentMediaManagerPlugin;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Brickx\MaintenanceSwitch\MaintenanceSwitchPlugin;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Awcodes\FilamentQuickCreate\QuickCreatePlugin;
use Modules\Filament\Resources\UserResource;
use Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin;
use Vormkracht10\FilamentMails\Facades\FilamentMails;
use Statikbe\FilamentTranslationManager\FilamentTranslationManager;
use App\Enums\ClientLocale;
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
use Filament\Tables\Table;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

final class SuperAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
//            ->brandName('بازار الان دادااش')
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
                    ->usingQueue(Queue::BACKUP->value)
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
                    ->avatarUploadComponent(fn () => FileUpload::make('avatar_url')->disk(StorageDisk::PUBLIC->value))
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
        Table::configureUsing(static fn (Table $table) => $table
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
        return collect(config('tools'))->except('backend-admin')
            ->map(
                fn (array $tool) => NavigationItem::make()
                    ->label(fn (): string => trans($tool['title']))
                    ->url($tool['url'], shouldOpenInNewTab: false)
                    ->icon($tool['heroicon'])
                    ->group($tool['group'])
                    ->sort($tool['sort'])
            )
            ->all();
    }
}
