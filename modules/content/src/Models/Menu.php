<?php

declare(strict_types=1);

namespace Modules\Content\Models;

use App\Models\Scopes\LatestScope;
use Cviebrock\EloquentSluggable\Sluggable;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Database\Eloquent\Attributes\UseResourceCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsUri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Content\Database\Factories\MenuFactory;
use Modules\Content\Http\Resources\App\MenuCollection;
use Modules\Content\Http\Resources\App\MenuResource;

#[UseFactory(MenuFactory::class)]
#[UseResource(MenuResource::class)]
#[UseResourceCollection(MenuCollection::class)]
#[ScopedBy([LatestScope::class])]
final class Menu extends Model
{
    use CascadeSoftDeletes;

    // _____________________________________________ use SECTION ______________________________________________
    use HasFactory;

    use Sluggable;

    use SoftDeletes;

    // _____________________________________________ props SECTION ______________________________________________
    protected array $cascadeDeletes = ['children'];

    protected $guarded = ['id', 'slug'];

    // _____________________________________________ model related methods SECTION ______________________________

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    // _____________________________________________ relations SECTION __________________________________________
    /**
     * @return HasMany<Menu, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return BelongsTo<Menu, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id')->withDefault(['name' => __('Unknown parent')]);
    }

    #[Scope]
    protected function loadChildren(Builder $query, int $levels = 4): Builder
    {
        $constraintsCallback = static function (Builder $query): void {
            $query->where('status', true);
        };

        // Build the relationship array with nested constraints
        $relations = collect(range(1, $levels))
            ->mapWithKeys(function (int $level) use ($constraintsCallback) {
                // Build the relationship path string
                $relationPath = 'children' . str_repeat('.children', $level - 1);

                return [$relationPath => $constraintsCallback];
            })
            ->all();

        return $query->with($relations);
    }

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'url'    => AsUri::class,
        ];
    }

    // _____________________________________________ methods SECTION ____________________________________________
}
