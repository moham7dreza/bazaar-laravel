<?php

declare(strict_types=1);

namespace Modules\Region\Providers;

use Illuminate\Support\ServiceProvider;
use Override;

class RegionServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
    }

    public function boot(): void
    {
    }
}
