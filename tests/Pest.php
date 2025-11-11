<?php

declare(strict_types=1);

use App\Enums\UserPermission;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\TestDataGenerator;

pest()->extend(TestCase::class)
    ->use(DatabaseTransactions::class)
    ->in('Feature', 'EndToEnd', '../modules/*/tests/Feature', '../modules/*/tests/EndToEnd');

pest()->extend(Tests\UnitTestCase::class)
    ->in('Arch', 'Unit', '../modules/*/tests/Arch', '../modules/*/tests/Unit');

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

expect()->extend('toContainPersianCharacters', fn () => $this->toMatch(
    '/[\x{0600}-\x{06FF}\x{FB8A}\x{067E}\x{0686}\x{06AF}\x{0698}\x{06A9}\x{06CC}]/u',
    'String must contain at least one Persian character.'
));

expect()->extend('toHaveNoPlaceholders', fn () => $this->toBeString()->not()->toMatch('/:\w+/'));

// ****************************************************** methods

function a(): TestDataGenerator
{
    return new TestDataGenerator();
}

/**
 * @phpstan-template T
 *
 * @param  Closure(): T  $callback
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
    // TODO: fix seeder and remove
    Spatie\Permission\Models\Permission::findOrCreate(UserPermission::SeePanel->value);

    $user->givePermissionTo(
        UserPermission::SeePanel,
    );

    return test()->be($user);
}

/**
 * Resolve provided FormRequest class and call `validateResolved` method with the given parameters.
 * It will return an empty array if validation succeeds or an array of failed parameter names
 * in case of validation failures.
 *
 * @param  class-string<Illuminate\Foundation\Http\FormRequest>  $class
 *
 * @throws ReflectionException
 */
function validateFormRequest(string $class, array $parameters): array
{
    try
    {
        $request = request()->create('/', 'POST', $parameters);
        app()->bind('request', fn () => $request);
        app($class);

        return [];
    } catch (Illuminate\Validation\ValidationException $e)
    {
        return $e->validator->errors()->keys();
    }
}
