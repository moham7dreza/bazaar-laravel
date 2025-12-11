<?php

declare(strict_types=1);

namespace Modules\Advertise\Repositories\Search;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Modules\Advertise\DataContracts\AdvertisementSearchDTO;
use Modules\Advertise\Enums\Sort;
use Modules\Advertise\Models\Advertisement;

final readonly class AdvertisementElasticSearchRepository implements AdvertisementSearchRepository
{
    public function __construct(
        private Client $elasticsearch,
    ) {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(AdvertisementSearchDTO $searchDTO): Collection
    {
        return $this->buildCollection(
            $this->searchOnElasticsearch($searchDTO)
        );
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    private function searchOnElasticsearch(AdvertisementSearchDTO $searchDTO): array
    {
        $model = new Advertisement();

        $body = [];
        // Phrase logic
        if ($searchDTO->phrase)
        {
            Arr::set($body, 'query', [
                'multi_match' => [
                    'fields' => ['title^5', 'description', 'tags'],
                    'query'  => $searchDTO->phrase,
                ],
            ]);
        } else
        {
            Arr::set($body, 'query', [
                'match_all' => (object) [],
            ]);
        }

        // ID filtering
        if (filled($searchDTO->ids))
        {
            $idFilter = [
                'terms' => ['_id' => $searchDTO->ids],
            ];
            Arr::set($body, 'query', [
                'bool' => [
                    'must'   => Arr::get($body, 'query'),
                    'filter' => [$idFilter],
                ],
            ]);
        }

        // Sorting
        if (null !== $searchDTO->sort)
        {
            switch ($searchDTO->sort)
            {
                // TODO use relation
                case Sort::PriceAsc:
                    Arr::set($body, 'sort', [['price' => ['order' => 'asc']]]);
                    break;
                case Sort::PriceDesc:
                    Arr::set($body, 'sort', [['price' => ['order' => 'desc']]]);
                    break;
                case Sort::Newest:
                    Arr::set($body, 'sort', [['created_at' => ['order' => 'desc']]]);
                    break;
                case Sort::Oldest:
                    Arr::set($body, 'sort', [['created_at' => ['order' => 'asc']]]);
                    break;
                default:
                    break;
            }
        }

        // Pagination
        Arr::set($body, 'from', ($searchDTO->page - 1) * $searchDTO->perPage);
        Arr::set($body, 'size', $searchDTO->perPage);

        $params = [
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'body'  => $body,
        ];

        return $this->elasticsearch->search($params)->asArray();
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck(Arr::get($items, 'hits.hits'), '_id');

        return Advertisement::query()
            ->findMany($ids)
            ->sortBy(fn (Advertisement $advertisement): int|string|false => array_search($advertisement->getKey(), $ids, true));
    }
}
