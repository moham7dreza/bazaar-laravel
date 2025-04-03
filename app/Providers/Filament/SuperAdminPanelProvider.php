<?php

namespace App\Providers\Filament;

use App\Enums\Language;
use App\Enums\Queue;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
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
            ->spa()
            ->default()
            ->id('super-admin')
            ->path('super-admin')
//            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop()
            ->globalSearchKeyBindings(['command+i', 'ctrl+i'])
            ->login()
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
            ])
            ->navigationItems($this->getNavItems());
    }

    public function boot(): void
    {
        LanguageSwitch::configureUsing(static function (LanguageSwitch $switch) {
            $switch
                ->locales(Language::values());
        });
    }

    private function getNavItems(): array
    {
        return [
            NavigationItem::make()
                ->label(fn (): string => __('Root'))
                ->url('/', shouldOpenInNewTab: true)
                ->icon('heroicon-o-presentation-chart-line')
                ->group('Tools')
                ->sort(0),
            NavigationItem::make()
                ->label(fn (): string => __('Mainweb'))
                ->url('http://localhost:3000', shouldOpenInNewTab: true)
                ->icon('heroicon-o-presentation-chart-line')
                ->group('Tools')
                ->sort(0),
            NavigationItem::make()
                ->label(fn (): string => __('Api Docs'))
                ->url('/docs/api', shouldOpenInNewTab: true)
                ->icon('heroicon-o-presentation-chart-line')
                ->group('Tools')
                ->sort(0),
            NavigationItem::make()
                ->label(fn (): string => __('Telescope'))
                ->url('/'.config('telescope.path'), shouldOpenInNewTab: true)
                ->icon('heroicon-o-magnifying-glass-circle')
                ->group('Tools')
                ->sort(2),
            NavigationItem::make()
                ->label(fn (): string => __('Monitoring'))
                ->url('/health?fresh', shouldOpenInNewTab: true)
                ->icon('heroicon-o-magnifying-glass-circle')
                ->group('Tools')
                ->sort(2),
            NavigationItem::make()
                ->label(fn (): string => __('Logging'))
                ->url('/'.config('log-viewer.route_path'), shouldOpenInNewTab: true)
                ->icon('heroicon-o-exclamation-triangle')
                ->group('Tools')
                ->sort(1),
            NavigationItem::make()
                ->label(fn (): string => __('Pulse'))
                ->url('/'.config('pulse.path'), shouldOpenInNewTab: true)
                ->icon('heroicon-o-arrow-trending-up')
                ->group('Tools')
                ->sort(3),
            NavigationItem::make()
                ->label(fn (): string => __('Horizon'))
                ->url('/'.config('horizon.path'), shouldOpenInNewTab: true)
                ->icon('heroicon-o-queue-list')
                ->group('Tools')
                ->sort(4),
            NavigationItem::make()
                ->label(fn (): string => __('Metrics'))
                ->url('/'.config('prometheus.urls.default'), shouldOpenInNewTab: true)
                ->icon('heroicon-o-queue-list')
                ->group('Tools')
                ->sort(4),
        ];
    }
}
