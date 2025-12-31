<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Region\Database\Seeders\IranCitiesSeeder;

final class TestsReferenceDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            IranCitiesSeeder::class,
        ]);
    }
}
