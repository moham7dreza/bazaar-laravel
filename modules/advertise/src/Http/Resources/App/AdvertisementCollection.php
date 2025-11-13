<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class AdvertisementCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'status'   => 200,
                'messages' => [],
            ],
        ];
    }
}
