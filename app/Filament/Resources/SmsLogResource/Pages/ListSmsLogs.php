<?php

namespace App\Filament\Resources\SmsLogResource\Pages;

use App\Enums\SmsStatus;
use App\Filament\Resources\SmsLogResource;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSmsLogs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = SmsLogResource::class;

    protected function getHeaderWidgets(): array
    {
        return SmsLogResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'delivered' => Tab::make()->query(fn (Builder $query) => $query->whereNotNull('delivered_at')),
            'queued' => Tab::make()->query(fn (Builder $query) => $query->where('status', SmsStatus::QUEUED)),
        ];
    }
}
