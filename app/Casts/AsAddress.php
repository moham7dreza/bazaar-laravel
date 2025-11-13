<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Support\Arr;
use App\Data\ValueObjects\Address;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class AsAddress implements CastsAttributes, SerializesCastableAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): Address
    {
        return new Address(
            Arr::get($attributes, 'address_line_one'),
            Arr::get($attributes, 'address_line_two')
        );
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        throw_unless($value instanceof Address, InvalidArgumentException::class, 'The given value is not an Address instance.');

        return [
            'address_line_one' => $value->lineOne,
            'address_line_two' => $value->lineTwo,
        ];
    }

    public function serialize(Model $model, string $key, mixed $value, array $attributes): string
    {
        return (string) $value;
    }
}
