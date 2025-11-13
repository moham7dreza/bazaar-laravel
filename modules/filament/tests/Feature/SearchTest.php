<?php

declare(strict_types=1);

use Filament\Livewire\GlobalSearch;

use function Pest\Livewire\livewire;

it('can search in filament panel', function (): void {

    asAnAuthenticatedUser();

    livewire(GlobalSearch::class)
        ->set('search', 'test')
        ->assertSuccessful();
});
