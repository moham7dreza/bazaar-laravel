<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Date;

trait Attributable
{
    use HasRelationships;

    /**
     * Get attributes.
     *
     * @return MorphMany
     */
    public function attributes(): MorphMany
    {
        return $this->morphMany(
            config('laravel-attributes.attributes_model'),
            'attributable'
        );
    }

    /**
     * Attach attribute.
     *
     * @param  string  $title
     * @param  string  $value
     * @return Builder|Model
     */
    public function attachAttribute(string $title, string $value): Model|Builder
    {
        $attributes = [
            'title' => $title,
            'value' => $value,
        ];

        return $this->attributes()->create($attributes);
    }

    /**
     * Attach multiple attributes. send array of array with title and value keys.
     *
     * @return $this
     *
     * @example
     * [
     *  [
     *      'key' => 'key',
     *      'value' => 'value',
     *  ]
     * ]
     */
    public function attachAttributes(array $values): static
    {
        foreach ($values as $key => $value)
        {
            $value = [
                'attributable_id'   => $this->getKey(),
                'attributable_type' => $this->getMorphClass(),
                'created_at'        => $now = Date::now()->toDateTimeString(),
                'updated_at'        => $now,
                ...$value,
            ];
            Arr::set($values, $key, $value);
        }

        $this->attributes()->insert($values);

        return $this;
    }

    /**
     * Check attribute have special value.
     *
     * @param  string  $value
     * @return bool
     */
    public function hasAttributeValue(string $value): bool
    {
        return $this->attributes()
            ->where('value', $value)
            ->exists();
    }

    /**
     * Check attribute have special title.
     *
     * @param  string  $title
     * @return bool
     */
    public function hasAttributeTitle(string $title): bool
    {
        return $this->attributes()
            ->where('title', $title)
            ->exists();
    }

    /**
     * Delete all attributes.
     *
     * @return Attributable
     */
    public function deleteAllAttributes(): static
    {
        $this->attributes()->delete();

        return $this;
    }

    /**
     * Delete special attribute.
     *
     * @param  string  $title
     * @param  string  $value
     * @return int
     */
    public function deleteAttribute(string $title, string $value): int
    {
        return $this->attributes()
            ->where([
                'title' => $title,
                'value' => $value,
            ])
            ->delete();
    }

    /**
     * Delete attribute by title.
     *
     * @param  string  $title
     * @return bool
     */
    public function deleteAttributeByTitle(string $title): bool
    {
        return (bool) $this->attributes()
            ->where('title', $title)
            ->delete();
    }

    /**
     * Delete attribute by value.
     *
     * @param  string  $value
     * @return bool
     */
    public function deleteAttributeByValue(string $value): bool
    {
        return (bool) $this->attributes()
            ->where('value', $value)
            ->delete();
    }
}
