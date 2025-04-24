<?php

namespace App\Models;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class PaymentGateway extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/
    protected $fillable = [
        'gateway',
        'owner',
        'config',
        'status',
        'sort_order',
        'owner_id',
        'owner_type',
    ];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    protected function casts(): array
    {
        return [
            'config' => 'array',
            'status' => 'bool',
//        'gateway' => \App\Enums\PaymentGateways::class,
        ];
    }

    #[Scope]
    public function active(): Builder
    {
        return $this->where('status', true);
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    public function ownerable(): MorphTo
    {
        return $this->morphTo();
    }

    /*** _____________________________________________ method SECTION __________________________________________ ***/
}
