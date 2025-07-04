<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserActionTagFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'action_tag' => 'string',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function hasAction(int $userId, string $tag): bool
    {
        return static::where('user_id', $userId)
            ->where('action_tag', $tag)
            ->exists();
    }

    public static function addAction(int $userId, string $tag): self
    {
        return static::create([
            'user_id' => $userId,
            'action_tag' => $tag,
        ]);
    }
}
