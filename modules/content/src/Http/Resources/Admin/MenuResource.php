<?php

declare(strict_types=1);

namespace Modules\Content\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

final class MenuResource extends JsonResource
{
    #[Override]
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'url'        => $this->url->value(),
            'slug'       => $this->slug,
            'position'   => $this->position,
            'parent_id'  => $this->parent_id,
            'icon'       => $this->icon,
            'status'     => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
