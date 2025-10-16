<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Modules\Auth\Enums\NoticeType;
use Modules\Auth\Models\Otp;

it('can register a user', function (): void {

//    Event::fake();

    $userData = [
        'name'                  => 'Test User',
        'email'                 => 'user@example.com',
        'password'              => 'Password1',
        'password_confirmation' => 'Password1',
        'mobile'                => '09120000000',
    ];

    \Pest\Laravel\postJson(route('auth.register'), $userData)->assertNoContent();

    $user = User::query()->firstWhere([
        'name'   => 'Test User',
        'email'  => 'user@example.com',
        'mobile' => '09120000000',
    ]);

    expect($user)->not->toBeNull();

    Pest\Laravel\assertAuthenticated();

//    Event::assertDispatchedTimes(Registered::class);
});

it('can send otp with user', function (): void {

    $user = User::factory()->create();

    $response = \Pest\Laravel\postJson(route('auth.send-otp'), [
        'mobile' => $user->mobile,
    ])
        ->assertOk();

    $otp = Otp::query()->firstWhere([
        'login_id' => $user->mobile,
        'type'     => NoticeType::SMS,
        'attempts' => 0,
        'user_id'  => $user->id,
    ]);

    expect($otp)->not->toBeNull()
        ->and($otp?->token)->toBe($response->json('data.token'));
});

it('can send otp without user', function (): void {

    $response = \Pest\Laravel\postJson(route('auth.send-otp'), [
        'mobile' => $mobile = '09120000001',
    ])
        ->assertOk();

    $otp = Otp::query()->firstWhere([
        'login_id' => $mobile,
        'type'     => NoticeType::SMS,
        'attempts' => 0,
        'user_id'  => null,
    ]);

    expect($otp)->not->toBeNull()
        ->and($otp?->token)->toBe($response->json('data.token'));
});

it('can verify otp without user', function (): void {

    Event::fake();

    $mobile  = '09120000002';
    $otpCode = '1234';
    $token   = 'testtoken';

    Otp::factory()->create([
        'login_id' => $mobile,
        'otp_code' => $otpCode,
        'token'    => $token,
        'used'     => false,
        'type'     => NoticeType::SMS,
    ]);

    \Pest\Laravel\postJson(route('auth.verify-otp'), [
        'mobile' => $mobile,
        'otp'    => $otpCode,
        'token'  => $token,
    ])
        ->assertOk();

    $user = User::query()->firstWhere([
        'mobile' => $mobile,
    ]);

    expect($user)->not->toBeNull();

    Pest\Laravel\assertAuthenticated();

    Event::assertDispatchedTimes(Registered::class);
});

it('can verify otp with user', function (): void {

    Event::fake();

    $user = User::factory()->create();

    $mobile  = $user->mobile;
    $otpCode = '1234';
    $token   = 'testtoken';

    Otp::factory()->create([
        'login_id' => $mobile,
        'otp_code' => $otpCode,
        'token'    => $token,
        'used'     => false,
        'type'     => NoticeType::SMS,
    ]);

    \Pest\Laravel\postJson(route('auth.verify-otp'), [
        'mobile' => $mobile,
        'otp'    => $otpCode,
        'token'  => $token,
    ])
        ->assertOk();

    Pest\Laravel\assertAuthenticated();

    Event::assertDispatchedTimes(Registered::class);
});
