<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            'url' => $this->url,
            // 'advertisement' => $this->advertisement,
            'advertisement_id' => $this->advertisement_id,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'extra' => [
                'status' => true,
            ],
        ];
    }
}
