<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NotificationLog extends Model
{
    protected $collection = 'notification_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
