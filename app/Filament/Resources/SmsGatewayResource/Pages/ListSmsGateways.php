<?php

namespace App\Filament\Resources\SmsGatewayResource\Pages;

use App\Filament\Resources\SmsGatewayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSmsGateways extends ListRecords
{
    protected static string $resource = SmsGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
