<?php

declare(strict_types=1);

namespace App\Console\Commands\System;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;

class DataMigrationCommand extends MigrateMakeCommand
{
    public const string PATH = '/database/migrations/data-migrations';

    protected $signature = 'make:data-migration
        {name : The name of the migration}
        {--create : The table to be created}
        {--table : The table to migrate}
        {--path= : The location where the migration file should be created}';

    public function __construct()
    {
        parent::__construct(app('migration.creator'), app('composer'));
    }

    public function handle(): int
    {
        $this->getDefinition()
            ->getOption('path')
            ->setDefault(self::PATH);

        parent::handle();

        return self::SUCCESS;
    }
}
