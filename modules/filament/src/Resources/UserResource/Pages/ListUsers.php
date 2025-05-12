<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Modules\Filament\Resources\UserResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

final class ListUsers extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            null        => Tab::make('All'),
            'Suspended' => Tab::make()->query(fn (Builder $query) => $query->suspended()),
            'Inactive'  => Tab::make()->query(fn (Builder $query) => $query->where('is_active', 0)),
            'Admin'     => Tab::make()->query(fn (Builder $query) => $query->admin()),
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
