<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\CommandPerformanceLogResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Modules\Filament\Resources\CommandPerformanceLogResource;

final class ViewCommandPerformanceLog extends ViewRecord
{
    protected static string $resource = CommandPerformanceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //            Actions\EditAction::make(),
        ];
    }
}
