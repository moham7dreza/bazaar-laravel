<?php

declare(strict_types=1);

namespace Tests\EndToEnd\Api\Panel;

use App\Enums\UserPermission;
use App\Models\User;
use Modules\Advertise\Models\Advertisement;

test('writer can access to advertisements', function (): void {
    $writer = User::factory()->create()->givePermissionTo(UserPermission::EditAds);

    Advertisement::factory()->for($writer)->create();

    $response = asUser($writer)
        ->getJson(route('api.panel.advertisements.advertisement.index'))
        ->assertOk();

    expect($response->json('data.0.user_id'))->toBe($writer->id);
});
