<?php

declare(strict_types=1);

use function Pest\Livewire\livewire;

it('can search in filament panel', function (): void {

    asAnAuthenticatedUser();

    livewire(Filament\Livewire\GlobalSearch::class)
        ->set('search', 'test')
        ->assertSuccessful();
});
