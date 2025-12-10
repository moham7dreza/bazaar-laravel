<?php

declare(strict_types=1);

it('can act load test on home page', function (): void {
    // Run a load test on the home page with 50 virtual users
    $result = $this->loadTestUrl('/', [
        'virtual_users' => 50,
    ]);
    // Assert that the success rate is above 99%
    $this->assertVTSuccessful($result, 99);
    // Assert that the 95th percentile response time is below 150ms
    $this->assertVTP95ResponseTime($result, 2000);
});
