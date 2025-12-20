<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Facades\Date;

class Carbon extends \Illuminate\Support\Carbon implements UrlRoutable
{
    public function getRouteKey(): string
    {
        return $this->toDateString();
    }

    public function getRouteKeyName(): void
    {
        // @todo:high: Implement getRouteKeyName() method.
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return rescue(fn () => Date::make($value), report: false);
    }

    public function resolveChildRouteBinding($childType, $value, $field): void
    {
        // @todo:high: Implement resolveChildRouteBinding() method.
    }
}
