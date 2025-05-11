<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public static array $seeders;

    public function run(): void
    {
        $this->call([

        ]);

        if ( ! isEnvProduction())
        {
            collect(self::$seeders)->each(fn ($seeder) => $this->call($seeder));

            $this->call([
                TopToDownSeeder::class,
                PermissionSeeder::class,
            ]);
        }
    }
}
