<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Uppercase implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return mb_strtoupper((string) $value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return mb_strtolower((string) $value);
    }
}
