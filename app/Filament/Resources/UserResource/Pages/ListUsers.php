<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListUsers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'Suspended' => Tab::make()->query(fn (Builder $query) => $query->suspended()),
            'Inactive' => Tab::make()->query(fn (Builder $query) => $query->where('is_active', 0)),
            'Admin' => Tab::make()->query(fn (Builder $query) => $query->admin()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return UserResource::getWidgets();
    }
}
