<?php

namespace App\Filament\Resources\CommandPerformanceLogResource\Pages;

use App\Filament\Resources\CommandPerformanceLogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCommandPerformanceLog extends ViewRecord
{
    protected static string $resource = CommandPerformanceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\EditAction::make(),
        ];
    }
}
