<?php

declare(strict_types=1);

namespace Modules\Filament\Widgets;

use Cmsmaxinc\FilamentSystemVersions\Filament\Widgets\DependencyStat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Override;

final class VersionStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    #[Override]
    protected function getStats(): array
    {
        return [
            DependencyStat::make('Laravel')
                ->dependency('laravel/framework'),
            DependencyStat::make('FilamentPHP')
                ->dependency('filament/filament'),
            DependencyStat::make('PestPHP')
                ->dependency('pestphp/pest'),
        ];
    }
}
