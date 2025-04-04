<?php

namespace App\Models\User;

use App\Enums\NoticeType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otp extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/

    protected $guarded = ['id'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    protected function casts(): array
    {
        return [
            'type' => NoticeType::class,
            'used' => 'boolean',
        ];
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*** _____________________________________________ method SECTION __________________________________________ ***/

}
