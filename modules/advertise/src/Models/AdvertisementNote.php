<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Database\Factories\AdvertisementNoteFactory;

#[ScopedBy([LatestScope::class])]
#[UseFactory(AdvertisementNoteFactory::class)]
final class AdvertisementNote extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use Prunable;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    // _____________________________________________ model related methods SECTION ______________________________

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subMonths(6));
    }

    // _____________________________________________ relations SECTION __________________________________________
    /**
     * @return BelongsTo<Advertisement, $this>
     */
    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class)->withDefault(['title' => __('Unknown advertisement')]);
    }

    // _____________________________________________ method SECTION __________________________________________

}
