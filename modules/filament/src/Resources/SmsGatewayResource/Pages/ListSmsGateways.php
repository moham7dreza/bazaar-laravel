<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\SmsGatewayResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Modules\Filament\Resources\SmsGatewayResource;

final class ListSmsGateways extends ListRecords
{
    protected static string $resource = SmsGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
