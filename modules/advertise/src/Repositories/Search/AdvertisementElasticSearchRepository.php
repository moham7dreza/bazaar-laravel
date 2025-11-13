<?php

declare(strict_types=1);

namespace Modules\Advertise\Repositories\Search;

use Elastic\Elasticsearch;
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
        private Elasticsearch\Client $elasticsearch,
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
            $body['query'] = [
                'multi_match' => [
                    'fields' => ['title^5', 'description', 'tags'],
                    'query'  => $searchDTO->phrase,
                ],
            ];
        } else
        {
            $body['query'] = [
                'match_all' => (object) [],
            ];
        }
        // ID filtering
        if ( ! empty($searchDTO->ids))
        {
            $idFilter = [
                'terms' => ['_id' => $searchDTO->ids],
            ];
            $body['query'] = [
                'bool' => [
                    'must'   => $body['query'],
                    'filter' => [$idFilter],
                ],
            ];
        }
        // Sorting
        if ($searchDTO->sort)
        {
            switch ($searchDTO->sort)
            {
                case Sort::PriceAsc:
                    $body['sort'] = [['price' => ['order' => 'asc']]];
                    break;
                case Sort::PriceDesc:
                    $body['sort'] = [['price' => ['order' => 'desc']]];
                    break;
                case Sort::Newest:
                    $body['sort'] = [['created_at' => ['order' => 'desc']]];
                    break;
                case Sort::Oldest:
                    $body['sort'] = [['created_at' => ['order' => 'asc']]];
                    break;
                default:
                    break;
            }
        }
        // Pagination
        $body['from'] = ($searchDTO->page - 1) * $searchDTO->perPage;
        $body['size'] = $searchDTO->perPage;

        $params = [
            'index' => $model->getSearchIndex(),
            'type'  => $model->getSearchType(),
            'body'  => $body,
        ];

        return $this->elasticsearch->search($params)->asArray();
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Advertisement::findMany($ids)
            ->sortBy(fn (Advertisement $advertisement) => array_search($advertisement->getKey(), $ids, true));
    }
}
