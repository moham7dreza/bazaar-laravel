<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Collection;

it('can get sensitive data columns', function (): void {

    $user = User::factory()->make();

    $data = $user->getSensitiveColumns()->unique();

    expect($data)->toBeInstanceOf(Collection::class)
        ->toHaveLength(3)
        ->each->toBeString()
        ->and($data->toArray())->toContain('email', 'mobile', 'password');
});
