<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NotificationLog extends Model
{
    protected $table = 'notification_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
