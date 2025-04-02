<?php

namespace App\Filament\Traits;

trait FilamentRedirect
{
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
