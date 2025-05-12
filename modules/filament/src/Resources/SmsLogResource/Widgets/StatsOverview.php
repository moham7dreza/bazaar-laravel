<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\SmsLogResource\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Filament\Resources\SmsLogResource\Pages\ListSmsLogs;

final class StatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListSmsLogs::class;
    }

    protected function getStats(): array
    {
        $deliveryRate = 0;
        if ($this->getPageTableQuery()->whereNotNull('delivered_at')->count() > 0)
        {
            $deliveryRate = $this->getPageTableQuery()->count() / $this->getPageTableQuery()->whereNotNull('delivered_at')->count() * 100;
        }

        return [
            Stat::make(__('Delivery Rate'), $deliveryRate),
        ];
    }
}
