<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\StorageDisk;
use Closure;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;
use ReflectionFunction;

abstract class TestCase extends BaseTestCase
{
    /**
     * This static property is used for sharing data between test cases in a file/class.
     */
    protected static array $dataContainer = [];

    private static bool $migrated         = false;

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        static::$dataContainer = [];
    }

    protected function setUp(): void
    {
        parent::setUp();

        cache()->flush();

        $this->migrateAndSeed();

        foreach (StorageDisk::cases() as $case)
        {
            Storage::fake($case->value);
        }
    }

    public function addToDataContainer(Closure $callback, ?string $key = null)
    {
        if (null === $key)
        {
            $ref = new ReflectionFunction($callback);
            $key = $ref->getFileName() . ':' . $ref->getEndLine();
        }

        if ( ! isset(static::$dataContainer[$key]))
        {
            static::$dataContainer[$key] = $callback();
        }

        return static::$dataContainer[$key];
    }

    private function migrateAndSeed(): void
    {
        if ( ! self::$migrated && ! $this->isRunningInParallel())
        {
            $commands = [
                'migrate --force',
            ];

            foreach ($commands as $command)
            {
                $this->artisan($command);
            }

            self::$migrated = true;
        }
    }

    private function isRunningInParallel(): bool
    {
        return ! empty($_SERVER['LARAVEL_PARALLEL_TESTING']);
    }
}
