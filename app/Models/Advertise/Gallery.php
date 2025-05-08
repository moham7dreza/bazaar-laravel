<?php

namespace App\Models\Advertise;

use App\Models\Scopes\LatestScope;
use App\Observers\GalleryObserver;
use Database\Factories\Advertise\GalleryFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
#[ObservedBy([GalleryObserver::class])]
#[UseFactory(GalleryFactory::class)]
class Gallery extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'url' => 'array',
        ];
    }

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subMonths(6));
    }

    // _____________________________________________ relations SECTION __________________________________________

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class)->withDefault(['name' => __('Unknown advertisement')]);
    }

    // _____________________________________________ method SECTION __________________________________________

}
