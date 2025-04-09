<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Filament\Resources\UserResource\Pages\ListUsers;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListUsers::class;
    }

    protected function getStats(): array
    {
        return [
            Stat::make(__('Suspended Users'), $this->getPageTableQuery()->whereNotNull('suspended_at')->count()),
            Stat::make(__('Not Activated Users'), $this->getPageTableQuery()->where('is_active', 0)->count()),
            Stat::make(__('Mobile Not Verified Users'), $this->getPageTableQuery()->whereNull('mobile_verified_at')->count()),
            Stat::make(__('Email Not verified Users'), $this->getPageTableQuery()->whereNull('email_verified_at')->count()),
        ];
    }
}
