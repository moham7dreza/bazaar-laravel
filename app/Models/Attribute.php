<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $title
 * @property string $value
 * @property string $attributable
 * @property string|int $attributable_id
 */
class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('laravel-attributes.tables.name', 'attributes');

        parent::__construct($attributes);
    }

    public function attributable(): MorphTo
    {
        return $this->morphTo();
    }
}
