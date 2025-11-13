<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\SmsGatewayResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Filament\Resources\SmsGatewayResource;

final class EditSmsGateway extends EditRecord
{
    protected static string $resource = SmsGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
