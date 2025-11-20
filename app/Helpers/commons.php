<?php

declare(strict_types=1);

use App\Enums\Environment;
use App\Enums\UserId;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;
use Modules\Monitoring\Jobs\MongoLogJob;

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
            ? collect($images)->map(fn ($path): string => asset($path))->unique()->all()
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
    function mongo_info(
        string $log_key,
        array $data,
        bool $queueable = false
    ): void {
        if (app()->runningUnitTests())
        {
            return;
        }

        if ($queueable)
        {
            dispatch(new MongoLogJob($data, $log_key));

            return;
        }

        dispatch_sync(new MongoLogJob($data, $log_key));
    }
}

if ( ! function_exists('isEnvStaging'))
{
    function isEnvStaging(): bool
    {
        return app()->environment(Environment::Staging->value);
    }
}

if ( ! function_exists('isEnvLocalOrTesting'))
{
    function isEnvLocalOrTesting(): bool
    {
        if (app()->isLocal())
        {
            return true;
        }

        return app()->runningUnitTests();
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
        $currentUserId = request()->user()?->id;
        $resolvedCase  = is_int($currentUserId) ? UserId::tryFrom($currentUserId) : null;

        return $resolvedCase && in_array($resolvedCase, $Ids);
    }
}

if ( ! function_exists('admin'))
{
    function admin(): User
    {
        return User::query()->find(UserId::Admin->value);
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
        $command = sprintf('pbcopy < %s; rm %s;', $path, $path);
        }
        elseif (PHP_OS_FAMILY === 'Linux')
        {
            // Try xclip first, then xsel (sudo apt install xclip)
            $command = sprintf('xclip -selection clipboard < %s 2>/dev/null || xsel --clipboard --input < %s 2>/dev/null; rm %s;', $path, $path, $path);
        } elseif (PHP_OS_FAMILY === 'Windows')
        {
            $command = sprintf('clip < %s 2>/dev/null; rm %s;', $path, $path);
        } else
        {
            throw new RuntimeException('Unsupported operating system for clipboard operations');
        }

        Process::run($command)->throw();
    }
}

if ( ! function_exists('throw_exception'))
{
    /**
     * @throws Throwable
     */
    function throw_exception($exception, string $message = ''): void
    {
        if (is_string($exception) && class_exists($exception))
        {
            $exception = blank($message) ? new $exception() : new $exception($message);
        }

        if ( ! $exception instanceof Throwable)
        {
            throw new InvalidArgumentException(
                __('Parameter must be a Throwable instance or class name')
            );
        }

        app()->isProduction() ? report($exception) : throw $exception;
    }
}

if ( ! function_exists('parseCsvGenerator'))
{
    /**
     * PHP generators allow us to process one row at a time without storing the entire dataset in memory.
     *
     * @param  $filePath
     * @return Generator
     */
    function parseCsvGenerator($filePath): Generator
    {
        $handle = fopen($filePath, 'rb');

        while (($data = fgetcsv($handle, escape: '\\')) !== false)
        {
            yield $data; // Yield one row at a time
        }

        fclose($handle);
    }
}
