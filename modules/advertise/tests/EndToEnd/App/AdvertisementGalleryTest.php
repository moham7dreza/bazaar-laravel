<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api;

use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\Gallery;

use function Pest\Laravel\getJson;

beforeEach(function (): void {
    $this->advertisement = Advertisement::factory()
        ->has(Gallery::factory(), 'images')
        ->create([
            'title' => 'test-adv',
        ]);
});

it('can get advertisement gallery', function (): void {

    $response = getJson(route('advertisements.gallery.index', $this->advertisement->id))->assertOk();

    $data = $response->json('data');

    expect($data)->toHaveLength(1);
})->skip('fix api error');
