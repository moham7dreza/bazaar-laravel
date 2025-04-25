<?php

namespace App\Models\Advertise;

use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class Gallery extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected $guarded = ['id'];

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'url' => 'array',
        ];
    }

    // _____________________________________________ relations SECTION __________________________________________

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    // _____________________________________________ method SECTION __________________________________________

}
