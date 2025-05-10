<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'ads_type'    => $this->ads_type,
            'ads_status'  => $this->ads_status,
            //            'allCategories' => $this->getAllCategories($this->category),
            'category' => $this->category,
            'gallery'  => $this->images->map(fn ($image) => [
                'id'  => $image->id,
                'url' => $image->url,
            ]),
            'category_attributes' => $this->category->attributes->map(fn ($attribute) => [
                'id'   => $attribute->id,
                'name' => $attribute->name,
                'unit' => $attribute->unit,
            ]),
            'category_values' => $this->categoryValues->map(fn ($value) => [
                'id'    => $value->id,
                'value' => $value->value,
            ]),
            'category_attributes_with_values' => $this->category->attributes->map(function ($attribute) {
                $value = $this->categoryValues()->firstWhere('category_attribute_id', $attribute->id);

                return [
                    'id'    => $attribute->id,
                    'name'  => $attribute->name,
                    'unit'  => $attribute->unit,
                    'value' => $value ? $value->value : null,
                ];
            }),
            'city'             => $this->city,
            'slug'             => $this->slug,
            'published_at'     => $this->published_at,
            'expired_at'       => $this->expired_at,
            'view'             => $this->view,
            'status'           => $this->status,
            'contact'          => $this->contact,
            'is_special'       => $this->is_special,
            'is_ladder'        => $this->is_ladder,
            'image'            => $this->image,
            'price'            => $this->price,
            'tags'             => $this->tags,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
            'willing_to_trade' => $this->willing_to_trade,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'extra' => [
                'status'   => 200,
                'messages' => [],
            ],
        ];
    }

    private function getAllCategories($category)
    {
        $all = [];
        while ($category)
        {
            $all[] = [
                'id'   => $category->id,
                'name' => $category->name,
            ];
            $category = $category->parent;
        }

        return array_reverse($all);
    }
}
