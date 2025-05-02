<?php

namespace App\Concerns;

trait HasTeamScope
{
    protected static function bootHasTeamScope(): void
    {
        static::addGlobalScope('team', function ($builder) {
            $builder->where('team_id', auth()->user()->current_team_id);
        });

        static::saving(function ($model) {
            if (auth()->check()) {
                $model->team_id = auth()->user()->current_team_id;
            }
        });
    }
}
