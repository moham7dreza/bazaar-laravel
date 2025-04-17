<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'slug' => $this->slug,
            'position' => $this->position,
            'parent_id' => $this->parent_id,
            'icon' => $this->icon,
            'status' => $this->status,
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
