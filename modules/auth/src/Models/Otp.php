<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Auth\Database\Factories\OtpFactory;
use Modules\Auth\Enums\NoticeType;

#[UseFactory(OtpFactory::class)]
final class Otp extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________

    protected $guarded = ['id'];

    protected $hidden = [
        'otp_code',
    ];

    // _____________________________________________ relations SECTION __________________________________________

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'type' => NoticeType::class,
            'used' => 'boolean',
        ];
    }

    // _____________________________________________ method SECTION __________________________________________

}
