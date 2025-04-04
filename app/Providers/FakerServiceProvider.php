<?php

namespace App\Providers;

use App\Faker;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;

class FakerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new Faker\ImageFakesProvider($faker));
            $faker->addProvider(new Faker\CommonFakesProvider($faker));

            return $faker;
        });
    }

    public function boot(): void
    {
        //
    }
}
