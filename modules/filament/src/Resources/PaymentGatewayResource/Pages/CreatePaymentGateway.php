<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\PaymentGatewayResource\Pages;

use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Filament\Resources\PaymentGatewayResource;
use Override;

final class CreatePaymentGateway extends CreateRecord
{
    protected static string $resource = PaymentGatewayResource::class;

    #[Override]
    protected function handleRecordCreation(array $data): Model
    {
        Arr::set($data, 'owner_id', auth()->id());
        Arr::set($data, 'owner_type', User::class);

        return parent::handleRecordCreation($data);
    }
}
