<?php

namespace App\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use InfinityXTech\FilamentWorldMapWidget\Enums\Map;
use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;

class MapWidget extends WorldMapWidget
{
    public function stats(): array
    {
        return [
            'US' => fake()->numberBetween(1000, 9999),
            'RS' => fake()->numberBetween(1000, 9999),
            'RU' => fake()->numberBetween(1000, 9999),
            'IR' => fake()->numberBetween(1000, 9999),
            'SA' => fake()->numberBetween(1000, 9999),
        ];
    }

    public function map(): Map|string
    {
        return Map::WORLD_MERC;
    }

    public function tooltip(): string|Htmlable
    {
        return 'orders';
    }
}
