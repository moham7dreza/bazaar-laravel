<?php

declare(strict_types=1);

use Modules\Payment\Models\Payment;

it('test payment model', function (): void {
    dd(Payment::factory()->create());
});
