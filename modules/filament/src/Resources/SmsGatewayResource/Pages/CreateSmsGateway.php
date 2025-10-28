<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\SmsGatewayResource\Pages;

use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Modules\Filament\Resources\SmsGatewayResource;

final class CreateSmsGateway extends CreateRecord
{
    protected static string $resource = SmsGatewayResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        \Illuminate\Support\Arr::set($data, 'owner_id', auth()->id());
        \Illuminate\Support\Arr::set($data, 'owner_type', User::class);

        return parent::handleRecordCreation($data);
    }
}
