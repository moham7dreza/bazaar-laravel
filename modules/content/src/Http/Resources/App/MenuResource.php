<?php

declare(strict_types=1);

namespace Modules\Content\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'url'       => $this->url->value(),
            'slug'      => $this->slug,
            'position'  => $this->position,
            'parent_id' => $this->parent_id,
            'icon'      => $this->icon,
            'status'    => $this->status,
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
