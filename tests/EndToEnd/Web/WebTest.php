<?php

declare(strict_types=1);

use function Pest\Laravel\getJson;

it('can see root page', function (): void {
    getJson(route('web.welcome'))->assertOk();
});

it('can see tool page', function (): void {
    getJson(route('web.tool'))->assertOk()->assertViewIs('tool');
});
