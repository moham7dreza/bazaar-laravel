<?php

declare(strict_types=1);

namespace App\Concerns;

trait HasTeamScope
{
    protected static function bootHasTeamScope(): void
    {
        static::addGlobalScope('team', function ($builder): void {
            $builder->where('team_id', auth()->user()->current_team_id);
        });

        static::saving(function ($model): void {
            if (auth()->check())
            {
                $model->team_id = auth()->user()->current_team_id;
            }
        });
    }
}
