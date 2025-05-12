<?php

declare(strict_types=1);

namespace Modules\Filament\Traits;

trait FilamentRedirect
{
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
