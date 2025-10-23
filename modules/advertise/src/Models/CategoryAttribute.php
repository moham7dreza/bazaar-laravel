<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Database\Factories\CategoryAttributeFactory;
use Modules\Advertise\Enums\Unit;
use Modules\Advertise\Http\Resources\Admin\CategoryAttributeCollection;
use Modules\Advertise\Http\Resources\Admin\CategoryAttributeResource;

#[ScopedBy([LatestScope::class])]
#[UseFactory(CategoryAttributeFactory::class)]
#[UseResource(CategoryAttributeResource::class)]
#[UseResourceCollection(CategoryAttributeCollection::class)]
final class CategoryAttribute extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    // _____________________________________________ relations SECTION __________________________________________

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault(['name' => __('Unknown category')]);
    }

    public function categoryValues(): HasMany
    {
        return $this->hasMany(CategoryValue::class);
    }

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'unit'   => Unit::class,
            'status' => 'boolean',
        ];
    }

    // _____________________________________________ method SECTION __________________________________________

}
