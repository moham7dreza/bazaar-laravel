<?php

declare(strict_types=1);

namespace Modules\Advertise\Commands;

use Elastic\Elasticsearch;
use Illuminate\Console\Command;
use Modules\Advertise\Models\Advertisement;

use function Laravel\Prompts\info;

class AdvertisementReindexElasticCommand extends Command
{
    protected $signature = 'advertisement:reindex-elastic';

    protected $description = 'Command description';

    public function handle(Elasticsearch\Client $elasticsearch): int
    {
        info('Indexing all ads. This might take a while...');

        foreach (Advertisement::query()->cursor() as $advertise)
        {
            $elasticsearch->index([
                'index' => $advertise->getSearchIndex(),
                'type'  => $advertise->getSearchType(),
                'id'    => $advertise->getKey(),
                'body'  => $advertise->toSearchArray(),
            ]);

            $this->output->write('.');
        }

        return static::SUCCESS;
    }
}
