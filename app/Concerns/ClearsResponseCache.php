<?php

declare(strict_types=1);

namespace App\Concerns;

use Spatie\ResponseCache\Facades\ResponseCache;

trait ClearsResponseCache
{
    public static function bootClearsResponseCache(): void
    {
        self::created(static fn () => ResponseCache::clear());
        self::updated(static fn () => ResponseCache::clear());
        self::deleted(static fn () => ResponseCache::clear());
    }
}
