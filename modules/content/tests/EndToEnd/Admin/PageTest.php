<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Modules\Content\Models\Page;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->admin()->create();
});

it('can list all pages', function (): void {
    $page = Page::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.content.page.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($page);
});

it('can create page', function (): void {
    $payload = [
        'title'  => 'About Us',
        'slug'   => 'about-us',
        'body'   => 'This is the about us page content.',
        'status' => true,
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.content.page.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->slug->toBe(Arr::get($payload, 'slug'))
        ->body->toBe(Arr::get($payload, 'body'));

    $page = Page::query()->firstWhere('slug', Arr::get($payload, 'slug'));

    assertModelExists($page);
});

it('can show specific page', function (): void {
    $page = Page::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.content.page.show', $page))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($page->id)
        ->title->toBe($page->title)
        ->body->toBe($page->body);
});

it('can update page', function (): void {
    $page = Page::factory()->create();

    $payload = [
        'title'  => 'Updated Page',
        'slug'   => 'updated-page',
        'body'   => 'This is the updated page content.',
        'status' => false,
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.content.page.update', $page), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->title->toBe(Arr::get($payload, 'title'))
        ->slug->toBe(Arr::get($payload, 'slug'))
        ->body->toBe(Arr::get($payload, 'body'));

    $page->refresh();

    expect($page->title)->toBe(Arr::get($payload, 'title'))
        ->and($page->body)->toBe(Arr::get($payload, 'body'));
});

it('can delete page', function (): void {
    $page = Page::factory()->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.content.page.destroy', $page))
        ->assertNoContent();

    expect(Page::query()
        ->find($page->id))->toBeNull();
});

it('non-admin cannot access page admin routes', function (): void {
    $user = User::factory()->create();

    asUser($user)
        ->getJson(route('api.admin.content.page.index'))
        ->assertForbidden();
});
