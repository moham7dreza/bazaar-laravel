<?php

namespace App\Filament\Resources\SmsLogResource\Widgets;

use App\Filament\Resources\SmsLogResource\Pages\ListSmsLogs;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
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
        if ($this->getPageTableQuery()->whereNotNull('delivered_at')->count() > 0) {
            $deliveryRate = $this->getPageTableQuery()->count() / $this->getPageTableQuery()->whereNotNull('delivered_at')->count() * 100;
        }

        return [
            Stat::make(__('Delivery Rate'), $deliveryRate),
        ];
    }
}
