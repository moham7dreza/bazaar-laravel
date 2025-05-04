<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            //
        ]);

        if (! isEnvProduction()) {
            $this->call([
                TopToDownSeeder::class,
                PermissionSeeder::class,
            ]);
        }
    }
}
