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
                ModelSeeder::class,
                PermissionSeeder::class,
            ]);
        }
    }
}
