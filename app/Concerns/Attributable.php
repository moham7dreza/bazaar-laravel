<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;

trait Attributable
{
    use HasRelationships;

    /**
     * Get attributes.
     *
     * @return MorphMany
     */
    public function attributes()
    {
        return $this->morphMany(
            config('laravel-attributes.attributes_model'),
            'attributable'
        );
    }

    /**
     * Attach attribute.
     *
     * @return Builder|Model
     */
    public function attachAttribute(string $title, string $value)
    {
        $attributes = [
            'title'                => $title,
            'value'                => $value,
            'attributable_id'      => $this->getKey(),
            'attributable_type'    => $this->getMorphClass(),
        ];

        return $this->attributes()->create($attributes);
    }

    /**
     * Attach multiple attributes.
     *
     * @return $this
     */
    public function attachAttributes(array $values)
    {
        foreach ($values as $value)
        {
            Arr::set($value, 'attributable_id', $this->getKey());
            Arr::set($value, 'attributable_type', $this->getMorphClass());

            $this->attributes()->create($value);
        }

        return $this;
    }

    /**
     * Check attribute have special value.
     *
     * @return bool
     */
    public function hasAttributeValue(string $value)
    {
        return $this->getAttributeWhere()
            ->where('value', $value)
            ->exists();
    }

    /**
     * Check attribute have special title.
     *
     * @return bool
     */
    public function hasAttributeTitle(string $title)
    {
        return $this->getAttributeWhere()
            ->where('title', $title)
            ->exists();
    }

    /**
     * Delete all attributes.
     *
     * @return Attributable
     */
    public function deleteAllAttribute()
    {
        $attributes = $this->getAttributeWhere()->get();

        foreach ($attributes as $attribute)
        {
            $attribute->delete();
        }

        return $this;
    }

    /**
     * Delete special attribute.
     *
     * @return int
     */
    public function deleteAttribute(string $title, string $value)
    {
        return $this->getAttributeWhere()
            ->where('title', $title)
            ->where('value', $value)
            ->delete();
    }

    /**
     * Delete attribute by title.
     *
     * @return int
     */
    public function deleteAttributeByTitle(string $title)
    {
        return $this->getAttributeWhere()
            ->where('title', $title)
            ->delete();
    }

    /**
     * Delete attribute by value.
     *
     * @return int
     */
    public function deleteAttributeByValue(string $value)
    {
        return $this->getAttributeWhere()
            ->where('value', $value)
            ->delete();
    }

    /**
     * Get attribute with this (model).
     */
    private function getAttributeWhere(): MorphMany
    {
        return $this->attributes()
            ->where('attributable_id', $this->getKey())
            ->where('attributable_type', $this->getMorphClass());
    }
}
