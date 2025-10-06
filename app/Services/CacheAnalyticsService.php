<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Cache\Events\KeyForgotten;
use Illuminate\Cache\Events\KeyWritten;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

final class CacheAnalyticsService
{
    public function registerListeners(): void
    {
        Event::listen(function (CacheHit $event): void {
            $this->trackCacheOperation('hit', [
                'cache_key' => $event->key,
                'store'     => $event->store ?? 'default',
                'timestamp' => now(),
            ]);
        });

        Event::listen(function (CacheMissed $event): void {
            $this->trackCacheOperation('miss', [
                'cache_key' => $event->key,
                'store'     => $event->store ?? 'default',
                'timestamp' => now(),
            ]);
        });

        Event::listen(function (KeyWritten $event): void {
            $this->trackCacheOperation('write', [
                'cache_key'      => $event->key,
                'expiry_seconds' => $event->seconds,
                'store'          => $event->store ?? 'default',
                'timestamp'      => now(),
            ]);
        });

        Event::listen(function (KeyForgotten $event): void {
            $this->trackCacheOperation('delete', [
                'cache_key' => $event->key,
                'store'     => $event->store ?? 'default',
                'timestamp' => now(),
            ]);
        });
    }

    private function trackCacheOperation(string $operation, array $metadata): void
    {
        DB::table('cache_analytics')->insert([
            'operation_type' => $operation,
            'cache_key'      => $metadata['cache_key'],
            'store_name'     => $metadata['store'],
            'expiry_time'    => $metadata['expiry_seconds'] ?? null,
            'recorded_at'    => $metadata['timestamp'],
        ]);
    }
}
