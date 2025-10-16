<?php

declare(strict_types=1);

it('can view metrics', function (): void {

    $response = \Pest\Laravel\get(route('prometheus.default'), [
        'Authorization' => 'Bearer ' . config('prometheus.token'),
    ])->assertOk();

    $response->assertSee([
        'app_horizon_failed_jobs_per_hour',
        'app_horizon_jobs_per_minute',
        'app_horizon_master_supervisors',
        'app_horizon_recent_jobs',
        'app_horizon_status',
    ]);
});
