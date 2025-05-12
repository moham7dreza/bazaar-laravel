<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Filament\Resources\UserResource;
use Modules\Filament\Traits\FilamentRedirect;

final class CreateUser extends CreateRecord
{
    use FilamentRedirect;

    protected static string $resource = UserResource::class;
}
