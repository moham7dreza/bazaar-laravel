<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Observers\ElasticsearchObserver;
use Elastic\Elasticsearch\Client;

trait Searchable
{
    abstract public function toElasticsearchDocumentArray(): array;

    public static function bootSearchable(): void
    {
        if (config()->boolean('services.search.enabled'))
        {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public function elasticSearchIndex(Client $elasticsearchClient): void
    {
        $elasticsearchClient->index([
            'index' => $this->getTable(),
            'type'  => $this->getSearchType(),
            'id'    => $this->getKey(),
            'body'  => $this->toSearchArray(),
        ]);
    }

    public function elasticSearchDelete(Client $elasticsearchClient): void
    {
        $elasticsearchClient->delete([
            'index' => $this->getTable(),
            'type'  => $this->getSearchType(),
            'id'    => $this->getKey(),
        ]);
    }
}
