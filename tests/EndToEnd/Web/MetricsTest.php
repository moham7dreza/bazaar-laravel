<?php

it('can view metrics', function () {

    $response = $this->get(route('prometheus.default'), [
        'Authorization' => 'Bearer '.getenv('BEARER_TOKEN'),
    ])->assertOk();

    $response->assertSee([
        'app_horizon_failed_jobs_per_hour',
        'app_horizon_jobs_per_minute',
        'app_horizon_master_supervisors',
        'app_horizon_recent_jobs',
        'app_horizon_status',
    ]);
});
