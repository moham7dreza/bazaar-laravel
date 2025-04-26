<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Fluent;

it('can get memoized cache value', function () {

    /*
     * When you memoize a value, it is stored in memory for the duration of the request.
     * This means that if you change the value in the cache store, it will not affect the memoized value.
     * */

    cache()->put('foo', 'bar');

    expect(cache()->memo()->get('foo'))->toBe('bar');

    cache()->put('foo', 'bar222');

    expect(cache()->memo()->get('foo'))->toBe('bar');

    cache()->driver('database')->put('foo', 'bar111');

    expect(cache()->memo()->get('foo'))->toBe('bar')
        ->and(cache()->memo('database')->get('foo'))->toBe('bar111');
})
    ->skip();

it('can conditionally modify values in a fluent instance', function () {

    $user = User::factory()->admin()->create();

    asAdminUser($user);

    expect($user->isAdmin())->toBeTrue();

    $data = Fluent::make([
        'name' => 'admin',
        'developer' => true,
        'posts' => 25,
    ])
        ->when($user->isAdmin(), function (Fluent $input) {

            return $input->set('role', UserRole::ADMIN->value);
        })
        ->unless($user->isAdmin(), function (Fluent $input) {

            return $input->except('posts');
        });

    expect($data->toArray())->toBe([
        'name' => 'admin',
        'developer' => true,
        'posts' => 25,
        'role' => UserRole::ADMIN->value,
    ]);
});
