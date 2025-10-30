<?php

declare(strict_types=1);

use Tests\TestGroup;

use function Pest\Stressless\stress;

pest()->group(TestGroup::MANUAL);

it('has a fast response time', function (): void {
    $result = stress('http://bazaar.local')
        ->concurrently(requests: 2)
        ->for(5)
        ->seconds()
        ->dump()
        ->verbosely();

    expect(
        $result
            ->requests()
            ->duration()
            ->med()
    )->toBeLessThan(100);
});
