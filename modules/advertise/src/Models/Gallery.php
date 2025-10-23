<?php

declare(strict_types=1);

namespace Modules\Advertise\Models;

use App\Enums\StorageDisk;
use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\Advertise\Database\Factories\GalleryFactory;
use Modules\Advertise\Http\Resources\App\GalleryCollection;
use Modules\Advertise\Http\Resources\App\GalleryResource;
use Modules\Advertise\Observers\GalleryObserver;

#[ScopedBy([LatestScope::class])]
#[ObservedBy([GalleryObserver::class])]
#[UseFactory(GalleryFactory::class)]
#[UseResource(GalleryResource::class)]
#[UseResourceCollection(GalleryCollection::class)]
final class Gallery extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use Prunable;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    public function prunable(): Builder
    {
        return self::query()->where('created_at', '<=', now()->subMonths(6));
    }

    // _____________________________________________ relations SECTION __________________________________________

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class)->withDefault(['name' => __('Unknown advertisement')]);
    }

    protected function pruning(): void
    {
        Storage::disk(StorageDisk::LOCAL->value)->delete($this->url);
    }

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'url' => 'array',
        ];
    }

    // _____________________________________________ method SECTION __________________________________________

}
