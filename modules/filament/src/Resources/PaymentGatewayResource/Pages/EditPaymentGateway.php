<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\PaymentGatewayResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Modules\Filament\Resources\PaymentGatewayResource;

final class EditPaymentGateway extends EditRecord
{
    protected static string $resource = PaymentGatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
