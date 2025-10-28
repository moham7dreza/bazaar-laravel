<?php

declare(strict_types=1);

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class NotificationLog extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $table = 'notification_logs';

    protected $connection = 'mongodb';

    protected $guarded = [];
}
