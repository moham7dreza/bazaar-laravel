<?php

use App\Models\User;

it('can see welcome page', function () {

    $this->getJson(route('web.welcome'))->assertOk()->assertViewIs('welcome');
});

it('can get health checks', function () {

    $user = User::factory()->admin()->create();

    $response = asAdminUser($user)->getJson(route('web.health-custom'))->assertOk();

    expect($response->json('data'))->toHaveLength(11);
});
