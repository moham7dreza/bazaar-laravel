<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\FilamentRedirect;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = UserResource::class;
}
