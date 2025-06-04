<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserActionTagFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

#[UseFactory(UserActionTagFactory::class)]
class UserActionTag extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $connection = 'mongodb';

    protected $table = 'user_action_tags';

    protected $fillable = [
        'user_id',
        'action_tag',
        'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'action_tag' => 'json',
        ];
    }
}
