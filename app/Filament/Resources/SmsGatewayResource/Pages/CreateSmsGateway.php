<?php

namespace App\Filament\Resources\SmsGatewayResource\Pages;

use App\Filament\Resources\SmsGatewayResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSmsGateway extends CreateRecord
{
    protected static string $resource = SmsGatewayResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data['owner_id'] = auth()->id();
        $data['owner_type'] = User::class;

        return parent::handleRecordCreation($data);
    }
}
