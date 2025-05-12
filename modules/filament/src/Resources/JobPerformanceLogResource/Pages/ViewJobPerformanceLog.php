<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\JobPerformanceLogResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Modules\Filament\Resources\JobPerformanceLogResource;

final class ViewJobPerformanceLog extends ViewRecord
{
    protected static string $resource = JobPerformanceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\EditAction::make(),
        ];
    }
}
