<?php

namespace App\Filament\Widgets;

use Cmsmaxinc\FilamentSystemVersions\Filament\Widgets\DependencyStat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class VersionStatsWidget extends BaseWidget
{
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
