<?php

namespace App\Models;

use App\Enums\Sms\SmsMessageType;
use App\Enums\Sms\SmsProvider;
use App\Enums\Sms\SmsSenderNumber;
use App\Enums\Sms\SmsStatus;
use App\Enums\Sms\SmsType;
use App\Models\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ScopedBy([LatestScope::class])]
class SmsLog extends Model
{
    // _____________________________________________ use SECTION ________________________________________________
    use HasFactory;
    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________

    //    protected $table = 'sms_logs';
    //
    //    protected $connection = 'mongodb';

    protected $guarded = ['id'];

    // _____________________________________________ model related methods SECTION ______________________________

    protected function casts(): array
    {
        return [
            'connector'     => SmsProvider::class,
            'status'        => SmsStatus::class,
            'type'          => SmsType::class,
            'message_type'  => SmsMessageType::class,
            'sender_number' => SmsSenderNumber::class,
            'sent_at'       => 'datetime',
            'delivered_at'  => 'datetime',
        ];
    }

    // _____________________________________________ relations SECTION __________________________________________

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault(['name' => __('Unknown user')]);
    }

    // _____________________________________________ methods SECTION __________________________________________

}
