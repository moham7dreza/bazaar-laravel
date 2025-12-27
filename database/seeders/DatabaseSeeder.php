<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Region\Database\Seeders\IranCitiesSeeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public static array $seeders;

    public function run(): void
    {
        $this->call([

        ]);

        if ( ! app()->isProduction())
        {
            $this->call([
                PermissionSeeder::class,
                IranCitiesSeeder::class,
                TopToDownSeeder::class,
            ]);

            collect(self::$seeders)->each(fn ($seeder) => $this->call($seeder));
        }
    }
}
