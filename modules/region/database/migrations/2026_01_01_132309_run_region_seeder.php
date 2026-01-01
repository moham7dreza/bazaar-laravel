<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Modules\Region\Database\Seeders\IranCitiesSeeder;

return new class() extends Migration {
    public function shouldRun(): bool
    {
        return app()->runningUnitTests();
    }

    public function up(): void
    {
        Artisan::call('db:seed', ['--class' => IranCitiesSeeder::class]);
    }
};
