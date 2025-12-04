<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Admin;

use App\Models\User;

use function Pest\Laravel\assertModelExists;

beforeEach(function (): void {
    $this->admin = User::factory()->admin()->create();
});

it('can list all users', function (): void {
    $user = User::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.users.user.index'))
        ->assertOk();

    expect($response->json('data'))->toBeArray();

    assertModelExists($user);
});

it('can create user', function (): void {
    $payload = [
        'name'     => 'Test User',
        'email'    => 'testuser@example.com',
        'mobile'   => '09123456789',
        'password' => 'password123!',
    ];

    $response = asUser($this->admin)
        ->postJson(route('api.admin.users.user.store'), $payload)
        ->assertCreated();

    expect($response->json('data'))
        ->name->toBe($payload['name'])
        ->email->toBe($payload['email'])
        ->mobile->toBe($payload['mobile']);

    $user = User::query()->firstWhere('email', $payload['email']);

    assertModelExists($user);
});

it('can show specific user', function (): void {
    $user = User::factory()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.users.user.show', $user))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($user->id)
        ->name->toBe($user->name)
        ->email->toBe($user->email);
});

it('can update user', function (): void {
    $user = User::factory()->create();

    $payload = [
        'name'   => 'Updated User',
        'email'  => 'updateduser@example.com',
        'mobile' => '09987654321',
    ];

    $response = asUser($this->admin)
        ->putJson(route('api.admin.users.user.update', $user), $payload)
        ->assertOk();

    expect($response->json('data'))
        ->name->toBe($payload['name'])
        ->email->toBe($payload['email'])
        ->mobile->toBe($payload['mobile']);

    $user->refresh();

    expect($user->name)->toBe($payload['name'])
        ->and($user->email)->toBe($payload['email']);
});

it('can delete user', function (): void {
    $user = User::factory()->create();

    asUser($this->admin)
        ->deleteJson(route('api.admin.users.user.destroy', $user))
        ->assertNoContent();

    expect(User::find($user->id))->toBeNull();
});

it('admin can view other admin users', function (): void {
    $otherAdmin = User::factory()->admin()->create();

    $response = asUser($this->admin)
        ->getJson(route('api.admin.users.user.show', $otherAdmin))
        ->assertOk();

    expect($response->json('data'))
        ->id->toBe($otherAdmin->id);
});

it('non-admin cannot access user admin routes', function (): void {
    $user = User::factory()->create();

    asUser($user)
        ->getJson(route('api.admin.users.user.index'))
        ->assertForbidden();
});
