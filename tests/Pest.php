<?php

declare(strict_types=1);

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Tests\TestDataGenerator;

pest()->extend(TestCase::class)
    ->use(DatabaseTransactions::class)
    ->in('Feature', 'EndToEnd', '../modules/*/tests');

expect()->extend(
    'toBeDefinedInEnum',
    /** @param class-string<BackedEnum> $enum */
    function (string $enum) {
        expect($enum)->toBeEnum();
        $resolved = $enum::tryFrom($this->value);
        expect($resolved)->toBeInstanceOf($enum, "'{$this->value}' is not defined in '{$enum}' enum.");

        return $this;
    }
);

function a(): TestDataGenerator
{
    return new TestDataGenerator();
}

/**
 * @phpstan-template T
 *
 * @param  Closure(): T  $callback
 * @param  string|null  $key
 * @return T
 */
function remember(Closure $callback, ?string $key = null)
{
    return test()->addToDataContainer($callback, $key);
}

function asUser(User $user): TestCase
{
    return test()->be($user);
}

function asAnAuthenticatedUser(): TestCase
{
    $user = User::factory()->create();

    return asUser($user);
}

function asAdminUser(User $user): TestCase
{
    Role::findOrCreate(UserRole::ADMIN->value);
    Permission::findOrCreate(UserPermission::SEE_PANEL->value);
    $user->assignRole(UserRole::ADMIN);

    return test()->be($user);
}

/**
 * Resolve provided FormRequest class and call `validateResolved` method with the given parameters.
 * It will return an empty array if validation succeeds or an array of failed parameter names
 * in case of validation failures.
 *
 * @param  class-string<Illuminate\Foundation\Http\FormRequest>  $class
 * @param  array  $parameters
 * @return array
 *
 * @throws ReflectionException
 */
function validateFormRequest(string $class, array $parameters): array
{
    try
    {
        $request = Request::create('/', 'POST', $parameters);
        app()->bind('request', fn () => $request);
        app($class);

        return [];
    } catch (Illuminate\Validation\ValidationException $e)
    {
        return $e->validator->errors()->keys();
    }
}
