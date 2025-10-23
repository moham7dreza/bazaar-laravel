<?php

declare(strict_types=1);

namespace Modules\Filament\Providers;

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
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: base_path('modules/filament/src/Widgets'), for: 'Modules\\Filament\\Widgets')
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
                        'sm'      => 2,
                        'md'      => 3,
                        'lg'      => 4,
                        'xl'      => 5,
                        '2xl'     => null,
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
                \Brickx\MaintenanceSwitch\MaintenanceSwitchPlugin::make(),
                \Swis\Filament\Backgrounds\FilamentBackgroundsPlugin::make(),
                \Awcodes\FilamentQuickCreate\QuickCreatePlugin::make()
                    ->slideOver()
                    ->keyBindings(['command+shift+a', 'ctrl+shift+a'])
                    ->includes([
                        \Modules\Filament\Resources\UserResource::class,
                    ]),
                \Cmsmaxinc\FilamentErrorPages\FilamentErrorPagesPlugin::make(),
            ])
            ->routes(fn () => \Vormkracht10\FilamentMails\Facades\FilamentMails::routes())
            ->navigationItems($this->getNavItems());
    }

    public function boot(): void
    {
        $this->configureLanguageSwitch();

        \Statikbe\FilamentTranslationManager\FilamentTranslationManager::setLocales(ClientLocale::values());

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
        return once(
            fn () => collect(config('tools'))->except('backend-admin')
                ->map(
                    fn (array $tool) => NavigationItem::make()
                        ->label(fn (): string => trans($tool['title']))
                        ->url($tool['url'], shouldOpenInNewTab: true)
                        ->icon($tool['heroicon'])
                        ->group($tool['group'])
                        ->sort($tool['sort'])
                )
                ->all()
        );
    }
}
