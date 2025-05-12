<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Modules\Filament\Traits\FilamentRedirect;

final class CreateUser extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = UserResource::class;
}
