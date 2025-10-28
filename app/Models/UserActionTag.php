<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserActionTagFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UseFactory(UserActionTagFactory::class)]
class UserActionTag extends Model
{
    use HasFactory;

    public const ?string UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'action_tag',
        'created_at',
    ];

    public static function hasAction(int $userId, string $tag): bool
    {
        return static::query()->where('user_id', $userId)
            ->where('action_tag', $tag)
            ->exists();
    }

    public static function addAction(int $userId, string $tag): self
    {
        return static::query()->create([
            'user_id'    => $userId,
            'action_tag' => $tag,
        ]);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'user_id'    => 'integer',
            'action_tag' => 'string',
            'created_at' => 'datetime',
        ];
    }
}
