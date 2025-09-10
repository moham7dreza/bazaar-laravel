<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\SmsLogResource\Pages;

use Filament\Schemas\Components\Tabs\Tab;
use App\Enums\Sms\SmsStatus;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Filament\Resources\SmsLogResource;

final class ListSmsLogs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = SmsLogResource::class;

    public function getTabs(): array
    {
        return [
            null        => Tab::make('All'),
            'delivered' => Tab::make()->query(fn (Builder $query) => $query->whereNotNull('delivered_at')),
            'queued'    => Tab::make()->query(fn (Builder $query) => $query->where('status', SmsStatus::QUEUED)),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return SmsLogResource::getWidgets();
    }
}
