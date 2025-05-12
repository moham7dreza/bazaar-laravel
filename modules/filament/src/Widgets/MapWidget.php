<?php

declare(strict_types=1);

namespace Modules\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use InfinityXTech\FilamentWorldMapWidget\Enums\Map;
use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;
use Modules\Advertise\Models\Advertisement;

final class MapWidget extends WorldMapWidget
{
    protected static ?int $sort = 0;

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
