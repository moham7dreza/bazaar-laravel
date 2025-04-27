<?php

use App\Enums\Environment;
use App\Models\User;

it('can generate routes', function (): void {

    $user = User::factory()->admin()->create();

    $response = asAdminUser($user)->getJson(route('web.domain-router'))->assertOk();

    expect($response->json('data'))->toHaveCount(4)
        ->api->toBeUrl()
        ->web->toBeUrl()
        ->assets->toBeUrl()
        ->environment->toBe(Environment::LOCAL->value);
});
