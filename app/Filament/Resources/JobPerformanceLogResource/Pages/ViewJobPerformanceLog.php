<?php

namespace App\Filament\Resources\JobPerformanceLogResource\Pages;

use App\Filament\Resources\JobPerformanceLogResource;
use Filament\Resources\Pages\ViewRecord;

class ViewJobPerformanceLog extends ViewRecord
{
    protected static string $resource = JobPerformanceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\EditAction::make(),
        ];
    }
}
