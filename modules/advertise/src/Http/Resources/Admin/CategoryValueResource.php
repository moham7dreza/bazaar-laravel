<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

final class CategoryValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'categoryAttribute' => $this->categoryAttribute,
            'value'             => $this->value,
            'type'              => $this->type,
            'status'            => $this->status,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
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
