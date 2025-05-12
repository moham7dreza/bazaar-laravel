<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\SmsLogResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Modules\Filament\Resources\SmsLogResource;

final class ViewSmsLog extends ViewRecord
{
    protected static string $resource = SmsLogResource::class;
}
