<?php

declare(strict_types=1);

namespace Modules\Advertise\Http\Resources\App;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;
use Modules\Advertise\Models\Gallery;

final class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Advertisement $this */
        $categoryAttributes = $this->category->attributes;
        $categoryValues     = $this->categoryValues;

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'ads_type'    => $this->ads_type,
            'ads_status'  => $this->ads_status,
            'user_id'     => $this->user_id,
            //            'allCategories' => $this->getAllCategories($this->category),
            'category' => $this->category,
            'gallery'  => $this->images->map(fn (Gallery $image) => [
                'id'  => $image->id,
                'url' => $image->url,
            ]),
            'category_attributes' => $categoryAttributes->map(fn (CategoryAttribute $attribute) => [
                'id'   => $attribute->id,
                'name' => $attribute->name,
                'unit' => $attribute->unit,
            ]),
            'category_values' => $categoryValues->map(fn (CategoryValue $value) => [
                'id'    => $value->id,
                'value' => $value->value,
            ]),
            'category_attributes_with_values' => $categoryAttributes->map(function (CategoryAttribute $attribute) use ($categoryValues) {
                $value = $categoryValues->firstWhere('category_attribute_id', $attribute->id);

                return [
                    'id'    => $attribute->id,
                    'name'  => $attribute->name,
                    'unit'  => $attribute->unit,
                    'value' => $value?->value,
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
