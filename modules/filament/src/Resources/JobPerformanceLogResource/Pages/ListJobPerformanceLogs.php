<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\JobPerformanceLogResource\Pages;

use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Filament\Resources\JobPerformanceLogResource;
use Override;

final class ListJobPerformanceLogs extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = JobPerformanceLogResource::class;

    public function getTabs(): array
    {
        return [
            null            => Tab::make('All'),
            'heavy queries' => Tab::make()->query(fn (Builder $query) => $query->highestQueryTime()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\CreateAction::make(),
        ];
    }

    #[Override]
    protected function getHeaderWidgets(): array
    {
        return JobPerformanceLogResource::getWidgets();
    }
}
