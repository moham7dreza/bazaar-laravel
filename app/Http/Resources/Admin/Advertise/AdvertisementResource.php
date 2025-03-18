<?php

namespace App\Http\Resources\Admin\Advertise;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'description' => $this->description,
            'ads_type' => $this->ads_type,
            'ads_status' => $this->ads_status,
            'category' => $this->category,
            'city' => $this->city,
            'user' => $this->user,
            'slug' => $this->slug,
            'published_at' => $this->published_at,
            'expired_at' => $this->expired_at,
            'view' => $this->view,
            'status' => $this->status,
            'contact' => $this->contact,
            'is_special' => $this->is_special,
            'is_ladder' => $this->is_ladder,
            'image' => $this->image,
            'price' => $this->price,
            'tags' => $this->tags,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'willing_to_trade' => $this->willing_to_trade,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
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
