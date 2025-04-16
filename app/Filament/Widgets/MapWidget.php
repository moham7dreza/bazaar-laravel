<?php

namespace App\Filament\Widgets;

use App\Models\Advertise\Advertisement;
use Illuminate\Contracts\Support\Htmlable;
use InfinityXTech\FilamentWorldMapWidget\Enums\Map;
use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;

class MapWidget extends WorldMapWidget
{
    public function stats(): array
    {
        return [
            'IR' => Advertisement::count(),
        ];
    }

    public function map(): Map|string
    {
        return Map::WORLD_MERC;
    }

    public function tooltip(): string|Htmlable
    {
        return 'ads';
    }

    public function color(): array
    {
        return [255, 0, 0];
    }
}
