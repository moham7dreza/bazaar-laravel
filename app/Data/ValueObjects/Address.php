<?php

namespace App\Data\ValueObjects;

use App\Casts\AsAddress;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class Address implements Castable, Arrayable, JsonSerializable
{
    public function __construct(
        public string $lineOne,
        public string $lineTwo,
    ) {
    }

    public static function castUsing(array $arguments): string
    {
        return AsAddress::class;
    }

    public function toArray(): array
    {
        return [
            'lineOne' => $this->lineOne,
            'lineTwo' => $this->lineTwo,
        ];
    }

    /**
     * @throws \JsonException
     */
    public function jsonSerialize(): mixed
    {
        $data = [
            'lineOne' => $this->lineOne,
            'lineTwo' => $this->lineTwo,
        ];

        return json_encode($data, JSON_THROW_ON_ERROR);
    }
}
