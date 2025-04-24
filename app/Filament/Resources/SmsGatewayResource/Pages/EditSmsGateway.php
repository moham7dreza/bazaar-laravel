<?php

namespace App\Filament\Resources\SmsGatewayResource\Pages;

use App\Filament\Resources\SmsGatewayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSmsGateway extends EditRecord
{
    protected static string $resource = SmsGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
