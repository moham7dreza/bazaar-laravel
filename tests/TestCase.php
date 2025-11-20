<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\StorageDisk;
use Closure;
use Database\Seeders\TestsReferenceDataSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Override;
use ReflectionFunction;

use function Pest\Laravel\artisan;

abstract class TestCase extends BaseTestCase
{
    /**
     * This static property is used for sharing data between test cases in a file/class.
     */
    protected static array $dataContainer = [];

    private static bool $migrated         = false;

    #[Override]
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        static::$dataContainer = [];
    }

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

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
                'db:seed --class=' . class_basename(TestsReferenceDataSeeder::class),
            ];

            foreach ($commands as $command)
            {
                artisan($command);
            }

            self::$migrated = true;
        }
    }

    private function isRunningInParallel(): bool
    {
        return filled(Request::server('LARAVEL_PARALLEL_TESTING'));
    }
}
