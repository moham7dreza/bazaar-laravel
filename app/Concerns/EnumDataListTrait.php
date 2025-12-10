<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Support\Collection;

trait EnumDataListTrait
{
    public static function list(): array
    {
        return array_map(static fn ($i): array => ['name' => $i->name, 'value' => $i->value], self::cases());
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function listByName(): array
    {
        return self::totalCases()->pluck('value', 'name')->toArray();
    }

    public static function totalCases(): Collection
    {
        return collect(self::cases());
    }

    public static function listByValue(): array
    {
        return self::totalCases()->pluck('name', 'value')->toArray();
    }

    public static function random()
    {
        return self::totalCases()->random();
    }

    /**
     * Concatenates all enum values into a single string, separated by commas.
     *
     * @return string A comma-separated string of all enum values.
     */
    public static function joinValues(): string
    {
        return self::collectValues()->implode(',');
    }

    public static function count(): int
    {
        return self::totalCases()->count();
    }

    public static function collectValues(): Collection
    {
        return collect(self::values());
    }
}
