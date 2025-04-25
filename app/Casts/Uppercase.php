<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Uppercase implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return strtoupper($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return strtolower($value);
    }
}
