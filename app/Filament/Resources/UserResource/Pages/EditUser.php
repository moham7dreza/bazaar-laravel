<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\FilamentRedirect;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kenepa\ResourceLock\Resources\Pages\Concerns\UsesResourceLock;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class EditUser extends EditRecord
{
    use FilamentRedirect;
    use UsesResourceLock;

    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        return [
            Impersonate::make()->record($this->getRecord()),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
