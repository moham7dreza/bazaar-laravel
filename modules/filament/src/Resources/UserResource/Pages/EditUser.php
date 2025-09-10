<?php

declare(strict_types=1);

namespace Modules\Filament\Resources\UserResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Kenepa\ResourceLock\Resources\Pages\Concerns\UsesResourceLock;
use Modules\Filament\Resources\UserResource;
use Modules\Filament\Traits\FilamentRedirect;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

final class EditUser extends EditRecord
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
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
