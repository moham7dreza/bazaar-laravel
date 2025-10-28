<?php

declare(strict_types=1);

use App\Enums\Environment;
use App\Enums\UserId;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Modules\Monitoring\Jobs\MongoLogJob;

if ( ! function_exists('getUser'))
{
    function getUser($request = null)
    {
        if (null === $request)
        {
            $request = request();
        }

        return $request->user();
    }
}

if ( ! function_exists('is_array_filled'))
{
    function is_array_filled(array $array): bool
    {
        return collect(array_values($array))->filter()->count() > 0;
    }
}

if ( ! function_exists('getImageList'))
{
    function getImageList($image): array|string
    {
        $images = is_string($image) ? [$image] : $image;

        return is_array($images)
            ? collect($images)->map(fn ($path) => asset($path))->unique()->all()
            : asset($images);
    }

}

if ( ! function_exists('ondemand_info'))
{
    function ondemand_info(string $message, array $context = [], string $file = 'custom'): void
    {
        Log::build([
            'driver' => 'single',
            'path'   => storage_path('logs/' . $file . '.log'),
            'level'  => 'info',
        ])->info($message, $context);
    }
}

if ( ! function_exists('mongo_info'))
{
    function mongo_info($log_key, $data, $queueable = false): void
    {
        if ( ! $data || isEnvTesting())
        {
            return;
        }
        try
        {
            $dispatch = $queueable ? 'dispatch' : 'dispatchSync';

            MongoLogJob::$dispatch($data, $log_key);
        } catch (Exception $exception)
        {

        }
    }
}

if ( ! function_exists('isEnvTesting'))
{
    function isEnvTesting(): bool
    {
        return app()->environment(Environment::TESTING->value);
    }
}

if ( ! function_exists('isEnvLocal'))
{
    function isEnvLocal(): bool
    {
        return app()->environment(Environment::local());
    }
}

if ( ! function_exists('isEnvStaging'))
{
    function isEnvStaging(): bool
    {
        return app()->environment(Environment::STAGING->value);
    }
}

if ( ! function_exists('isEnvProduction'))
{
    function isEnvProduction(): bool
    {
        return app()->environment(Environment::PRODUCTION->value);
    }
}

if ( ! function_exists('isEnvLocalOrTesting'))
{
    function isEnvLocalOrTesting(): bool
    {
        return app()->environment(Environment::localOrTesting());
    }
}

if ( ! function_exists('getSqlWithBindings'))
{
    function getSqlWithBindings(EloquentBuilder|QueryBuilder $query): string
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }
}

if ( ! function_exists('userIdIs'))
{
    function userIdIs(UserId ...$Ids): bool
    {
        $currentUserId = getUser()?->id;
        $resolvedCase  = is_int($currentUserId) ? UserId::tryFrom($currentUserId) : null;

        return $resolvedCase && in_array($resolvedCase, $Ids);
    }
}

if ( ! function_exists('admin'))
{
    function admin(): ?User
    {
        $user = User::query()->find(UserId::Admin->value)
            ?? User::query()->admin()->first();

        return $user?->isAdmin() ? $user : null;
    }
}

if ( ! function_exists('arrayKeySort'))
{
    function arrayKeySort(array $array): array
    {
        return collect($array)
            ->sortKeysUsing(function ($a, $b) {
                $numA = (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT);
                $numB = (int) filter_var($b, FILTER_SANITIZE_NUMBER_INT);

                return $numA <=> $numB;
            })
            ->toArray();
    }
}

if ( ! function_exists('c2c'))
{
    /**
     * copy to clipboard.
     *
     * @param  string  $content
     * @return void
     */
    function c2c(string $content): void
    {
        $path = tempnam('', 'laravel:c2c');
        file_put_contents($path, $content);
        // macOS
        if (PHP_OS_FAMILY === 'Darwin')
        {
        $command = "pbcopy < {$path}; rm {$path};";
        }
        elseif (PHP_OS_FAMILY === 'Linux')
        {
            // Try xclip first, then xsel (sudo apt install xclip)
            $command = "xclip -selection clipboard < {$path} 2>/dev/null || xsel --clipboard --input < {$path} 2>/dev/null; rm {$path};";
        } elseif (PHP_OS_FAMILY === 'Windows')
        {
            $command = "clip < {$path} 2>/dev/null; rm {$path};";
        } else
        {
            throw new RuntimeException('Unsupported operating system for clipboard operations');
        }

        Illuminate\Support\Facades\Process::run($command)->throw();
    }
}
