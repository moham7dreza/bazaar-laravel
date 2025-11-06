<?php

declare(strict_types=1);

namespace Modules\Payment\Models;

use App\Models\Scopes\LatestScope;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsEncryptedArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Advertise\Models\Advertisement;
use Modules\Payment\Database\Factories\PaymentFactory;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Http\Resources\PaymentCollection;
use Modules\Payment\Http\Resources\PaymentResource;

#[ScopedBy([LatestScope::class])]
#[UseResource(PaymentResource::class)]
#[UseResourceCollection(PaymentCollection::class)]
#[UseFactory(PaymentFactory::class)]
class Payment extends Model
{
    use HasFactory;
    use Prunable;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function prunable(): Builder
    {
        return static::query()->where('created_at', '<=', now()->subYear());
    }

    protected function casts(): array
    {
        return [
            'status'           => PaymentStatus::class,
            'gateway_response' => AsEncryptedArrayObject::class,
        ];
    }
}
