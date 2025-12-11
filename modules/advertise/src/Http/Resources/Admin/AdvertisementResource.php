<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Resources\Admin;

use Cknow\Money\Money;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

final class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[Override]
    public function toArray(Request $request): array
    {
        /** @var Money $price */
        $price = $this->currentPrice();

        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'description'      => $this->description,
            'ads_type'         => $this->ads_type,
            'ads_status'       => $this->ads_status,
            'category'         => $this->category,
            'city'             => $this->city,
            'user'             => $this->user,
            'slug'             => $this->slug,
            'published_at'     => $this->published_at,
            'expired_at'       => $this->expired_at,
            'view'             => $this->view,
            'status'           => $this->status,
            'contact'          => $this->contact,
            'is_special'       => $this->is_special,
            'is_ladder'        => $this->is_ladder,
            'image'            => $this->image,
            'price'            => $price->getAmount(),
            'tags'             => $this->tags,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
            'willing_to_trade' => $this->willing_to_trade,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
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
