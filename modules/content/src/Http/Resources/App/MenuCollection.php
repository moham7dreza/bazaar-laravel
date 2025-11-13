<?php

declare(strict_types=1);

namespace Modules\Content\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Override;

final class MenuCollection extends ResourceCollection
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
            'data'   => $this->collection,
            'status' => true,
        ];
    }

    #[Override]
    public function with($request)
    {
        return [
            'extra' => [
                'status' => true,
            ],
        ];
    }
}
