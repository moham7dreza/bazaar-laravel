<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Content\Models\Menu;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->create();
    $this->admin->makeAdmin();
});

it('can list all menus', function (): void {
    $menu = Menu::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.content.menu.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($menu);
});

it('can create menu', function (): void {
    $payload = [
        'title'    => 'Home',
        'url'      => 'https://example.com',
        'slug'     => 'home',
        'position' => 'header',
        'status'   => true,
        'icon'     => 'icon-home',
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.content.menu.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->url->toBe(Arr::get($payload, 'url'))
        ->slug->toBe(Arr::get($payload, 'slug'));

    $menu = Menu::query()->firstWhere('slug', Arr::get($payload, 'slug'));

    assertModelExists($menu);
});

it('can create menu with parent', function (): void {
    $parent = Menu::factory()->create();

    $payload = [
        'title'     => 'Sub Menu',
        'url'       => 'https://example.com/sub',
        'slug'      => 'sub-menu',
        'position'  => 'header',
        'status'    => true,
        'parent_id' => $parent->id,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.content.menu.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->parent_id->toBe($parent->id);

    $menu = Menu::query()->firstWhere('slug', Arr::get($payload, 'slug'));

    assertModelExists($menu);
});

it('can show specific menu', function (): void {
    $menu = Menu::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.content.menu.show', $menu))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($menu->id)
        ->title->toBe($menu->title);
});

it('can update menu', function (): void {
    $menu = Menu::factory()->create();

    $payload = [
        'title'    => 'Updated Menu',
        'url'      => 'https://example.com/updated',
        'slug'     => 'updated-menu',
        'position' => 'footer',
        'status'   => false,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.content.menu.update', $menu), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->url->toBe(Arr::get($payload, 'url'));

    $menu->refresh();

    expect($menu->title)->toBe(Arr::get($payload, 'title'))
        ->and($menu->url)->toBe(Arr::get($payload, 'url'));
});

it('can delete menu', function (): void {
    $menu = Menu::factory()->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.content.menu.destroy', $menu))
        ->assertNoContent();

    expect(Menu::query()
        ->find($menu->id))->toBeNull();
});

it('non-admin cannot access menu admin routes', function (): void {
    $user = User::factory()->create();

    asUser($user)
        ->getJson(route('api.admin.content.menu.index'))
        ->assertForbidden();
});
