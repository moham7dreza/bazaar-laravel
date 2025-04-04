<?php

namespace App\Models\Monitor;

use App\Enums\SmsMessageType;
use App\Enums\SmsProvider;
use App\Enums\SmsSenderNumber;
use App\Enums\SmsStatus;
use App\Enums\SmsType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsLog extends Model
{
    /*** _____________________________________________ use SECTION ________________________________________________ ***/
    use HasFactory;
    use SoftDeletes;

    /*** _____________________________________________ props SECTION ______________________________________________ ***/

    //    protected $table = 'sms_logs';
    //
    //    protected $connection = 'mongodb';

    protected $guarded = ['id'];

    /*** _____________________________________________ model related methods SECTION ______________________________ ***/

    protected function casts(): array
    {
        return [
            'connector' => SmsProvider::class,
            'status' => SmsStatus::class,
            'type' => SmsType::class,
            'message_type' => SmsMessageType::class,
            'sender_number' => SmsSenderNumber::class,
            'sent_at' => 'datetime',
            'delivered_at' => 'datetime',
        ];
    }

    /*** _____________________________________________ relations SECTION __________________________________________ ***/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*** _____________________________________________ methods SECTION __________________________________________ ***/

}
