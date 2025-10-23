<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api;

use App\Models\User;
use Modules\Advertise\Enums\Sort;
use Modules\Advertise\Models\Advertisement;
use Modules\Advertise\Models\AdvertisementNote;
use Modules\Advertise\Models\CategoryAttribute;
use Modules\Advertise\Models\CategoryValue;
use Modules\Advertise\Models\Gallery;

beforeEach(function (): void {

    $this->advertisement = Advertisement::factory()
        ->has(AdvertisementNote::factory(), 'advertisementNotes')
        ->has(Gallery::factory(), 'images')
        ->hasAttached(User::factory(2)->create(), relationship: 'favoritedByUsers')
        ->hasAttached(User::factory(2)->create(), relationship: 'viewedByUsers')
        ->hasAttached(CategoryValue::factory(2)->create(), relationship: 'categoryValues')
        ->create([
            'title' => 'test-adv',
        ]);

    CategoryAttribute::factory()->for($this->advertisement->category)->create();

});

afterEach(function (): void {

    \Pest\Laravel\assertModelExists($this->advertisement);
});

it('can get all advertisements', function (): void {

    $response = \Pest\Laravel\getJson(route('api.advertisements.index', [
        'title' => 'adv',
        'sort'  => Sort::NEWEST,
    ]))->assertOk();

    expect($response->json('data'))->toHaveLength(1);

    $data = $response->json('data.0');

    assertAdv($data, $this->advertisement->id);
});

it('can show a single advertisement', function (): void {

    $response = \Pest\Laravel\getJson(route('api.advertisements.show', $this->advertisement->id))->assertOk();

    $data = $response->json('data');

    assertAdv($data, $this->advertisement->id);
});

function assertAdv($data, $advertisement_id): void
{
    expect($data)->toHaveCount(28)
        ->id->toBe($advertisement_id)
        ->title->toBeString()
        ->description->toBeString()
        ->ads_type->toBeString()
        ->ads_status->toBeString()
        ->user_id->toBeInt()
//        ->allCategories->toBeArray() // have children
        ->category->toBeArray() // have children
        ->gallery->toBeArray() // have children
        ->category_attributes->toBeArray() // have children
        ->category_values->toBeArray() // have children
        ->category_attributes_with_values->toBeArray()// have children
        ->city->toBeArray()// have children
        ->slug->toBeString()
        ->published_at->toBeString()
        ->expired_at->toBeString()
        ->view->toBeInt()
        ->status->toBeBool()
        ->contact->toBeString()
        ->is_special->toBeBool()
        ->is_ladder->toBeBool()
        ->image->toBeArray()// have children
        ->price->toBeInt()
        ->tags->toBeString()
        ->lat->toBeString()
        ->lng->toBeString()
        ->willing_to_trade->toBeBool()
        ->created_at->toBeString()
        ->updated_at->toBeString();
}
