<?php

declare(strict_types=1);

namespace Modules\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use InfinityXTech\FilamentWorldMapWidget\Enums\Map;
use InfinityXTech\FilamentWorldMapWidget\Widgets\WorldMapWidget;
use Modules\Advertise\Models\Advertisement;
use Override;

final class MapWidget extends WorldMapWidget
{
    protected static ?int $sort = 0;

    #[Override]
    public function stats(): array
    {
        return [
            'IR' => Advertisement::query()->count(),
        ];
    }

    #[Override]
    public function map(): Map|string
    {
        return Map::WORLD_MERC;
    }

    #[Override]
    public function tooltip(): string|Htmlable
    {
        return 'ads';
    }

    #[Override]
    public function color(): array
    {
        return [255, 0, 0];
    }
}
