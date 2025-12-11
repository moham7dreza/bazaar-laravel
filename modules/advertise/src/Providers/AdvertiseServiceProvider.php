<?php

declare(strict_types=1);

namespace Modules\Advertise\Providers;

use Database\Seeders\DatabaseSeeder;
use Elastic\Elasticsearch\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Advertise\Commands\AdvertisementLadderCommand;
use Modules\Advertise\Commands\AdvertisementReindexElasticCommand;
use Modules\Advertise\Database\Seeders\AdvertisementSeeder;
use Modules\Advertise\Repositories\Search\AdvertisementElasticSearchRepository;
use Modules\Advertise\Repositories\Search\AdvertisementEloquentSearchRepository;
use Modules\Advertise\Repositories\Search\AdvertisementSearchRepository;
use Override;

final class AdvertiseServiceProvider extends ServiceProvider
{
    private const array COMMANDS = [
        AdvertisementLadderCommand::class,
        AdvertisementReindexElasticCommand::class,
    ];

    #[Override]
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
        DatabaseSeeder::$seeders[] = AdvertisementSeeder::class;
    }

    private function bindSearchRepository(): void
    {
         $this->app->bind(function (Application $app): AdvertisementSearchRepository {
            if ( ! config()->boolean('services.search.enabled'))
            {
                return new AdvertisementEloquentSearchRepository();
            }

            return new AdvertisementElasticSearchRepository(
                $app->make(Client::class)
            );
        });
    }
}
