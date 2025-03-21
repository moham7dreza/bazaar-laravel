<?php

namespace App\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
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
