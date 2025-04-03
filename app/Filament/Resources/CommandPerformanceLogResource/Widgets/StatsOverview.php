<?php

namespace App\Filament\Resources\CommandPerformanceLogResource\Widgets;

use App\Filament\Resources\CommandPerformanceLogResource\Pages\ListCommandPerformanceLogs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListCommandPerformanceLogs::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('Highest Query Time'), $this->getPageTableQuery()->highestQueryTime()->count()),
        ];
    }
}
