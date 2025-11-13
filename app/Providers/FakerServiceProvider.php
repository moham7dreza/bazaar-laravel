<?php

declare(strict_types=1);

namespace App\Providers;

use App\Faker;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Override;

class FakerServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        $this->app->singleton(function (): Generator {
            $faker = Factory::create();
            $faker->addProvider(new Faker\ImageFakesProvider($faker));
            $faker->addProvider(new Faker\CommonFakesProvider($faker));

            return $faker;
        });

        $this->app->bind(
            Generator::class . ':' . config('app.faker_locale'),
            Generator::class
        );
    }

    public function boot(): void
    {

    }
}
