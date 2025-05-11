<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Advertise\Database\Seeders\AdvertiseSeeder;
use Modules\Content\Database\Seeders\ContentSeeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

        ]);

        if ( ! isEnvProduction())
        {
            $this->call([
                TopToDownSeeder::class,
                AdvertiseSeeder::class,
                ContentSeeder::class,
                PermissionSeeder::class,
            ]);
        }
    }
}
