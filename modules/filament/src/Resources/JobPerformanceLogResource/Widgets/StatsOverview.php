<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\JobPerformanceLogResource\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Filament\Resources\JobPerformanceLogResource\Pages\ListJobPerformanceLogs;

final class StatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected ?string $pollingInterval = null;

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
