<?php

namespace App\Filament\Resources\PaymentGatewayResource\Pages;

use App\Filament\Resources\PaymentGatewayResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePaymentGateway extends CreateRecord
{
    protected static string $resource = PaymentGatewayResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data['owner_id'] = auth()->id();
        $data['owner_type'] = User::class;

        return parent::handleRecordCreation($data);
    }
}
