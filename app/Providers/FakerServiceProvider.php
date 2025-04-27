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
        $this->app->singleton(function (): \Faker\Generator {
            $faker = Factory::create();
            $faker->addProvider(new Faker\ImageFakesProvider($faker));
            $faker->addProvider(new Faker\CommonFakesProvider($faker));

            return $faker;
        });

        $this->app->bind(
            Generator::class.':'.config('app.faker_locale'),
            Generator::class
        );
    }

    public function boot(): void
    {
        //
    }
}
