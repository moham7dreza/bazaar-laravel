<?php

namespace App\Filament\Resources\JobPerformanceLogResource\Widgets;

use App\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListJobPerformanceLogs::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('Highest Query Time'), $this->getPageTableQuery()->highestQueryTime()->count()),
        ];
    }
}
