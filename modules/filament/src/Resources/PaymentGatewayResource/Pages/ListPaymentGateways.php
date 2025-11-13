<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\PaymentGatewayResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Filament\Resources\PaymentGatewayResource;

final class ListPaymentGateways extends ListRecords
{
    protected static string $resource = PaymentGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
