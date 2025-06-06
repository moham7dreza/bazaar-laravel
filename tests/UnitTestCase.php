<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

class UnitTestCase extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $app = require __DIR__ . '/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        DB::beforeExecuting(static function ($query): void {
            self::fail('Database connection is not allowed in unit tests.');
        });
    }

    public static function tearDownAfterClass(): void
    {
        restore_error_handler();
        restore_exception_handler();
    }
}
