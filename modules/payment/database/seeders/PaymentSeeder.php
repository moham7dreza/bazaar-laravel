<?php

declare(strict_types=1);

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::factory(10)->insert();
    }
}
