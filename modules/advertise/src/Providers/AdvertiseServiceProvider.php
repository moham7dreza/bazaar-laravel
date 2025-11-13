<?php

declare(strict_types=1);

namespace Modules\Advertise\Providers;

use Database\Seeders\DatabaseSeeder;
use Elastic\Elasticsearch;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Advertise\Commands\AdvertisementLadderCommand;
use Modules\Advertise\Commands\AdvertisementReindexElasticCommand;
use Modules\Advertise\Database\Seeders\AdvertiseSeeder;
use Modules\Advertise\Repositories\Search;

final class AdvertiseServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [
        AdvertisementLadderCommand::class,
        AdvertisementReindexElasticCommand::class,
    ];

    public function register(): void
    {
        $this->commands(self::COMMANDS);

        $this->setupSeeders();

        $this->bindSearchRepository();
    }

    public function boot(): void
    {
    }

    private function setupSeeders(): void
    {
        DatabaseSeeder::$seeders[] = AdvertiseSeeder::class;
    }

    private function bindSearchRepository(): void
    {
         $this->app->bind(function (Application $app): Search\AdvertisementSearchRepository {
            if ( ! config()->boolean('services.search.enabled'))
            {
                return new Search\AdvertisementEloquentSearchRepository();
            }

            return new Search\AdvertisementElasticSearchRepository(
                $app->make(Elasticsearch\Client::class)
            );
        });
    }
}
