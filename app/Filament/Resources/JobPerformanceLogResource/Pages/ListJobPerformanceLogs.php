<?php

namespace App\Filament\Resources\JobPerformanceLogResource\Pages;

use App\Filament\Resources\JobPerformanceLogResource;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListJobPerformanceLogs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = JobPerformanceLogResource::class;

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'heavy queries' => Tab::make()->query(fn (Builder $query) => $query->highestQueryTime()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return JobPerformanceLogResource::getWidgets();
    }
}
