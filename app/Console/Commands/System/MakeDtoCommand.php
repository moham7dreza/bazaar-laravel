<?php

declare(strict_types=1);

namespace App\Console\Commands\System;

use Illuminate\Console\GeneratorCommand;
use Override;

final class MakeDtoCommand extends GeneratorCommand
{
    protected $signature = 'make:dto {name}';

    protected $description = 'Create a new dto class';

    protected $type = 'class';

    protected function getStub()
    {
        return base_path('stubs/dto.stub');
    }

    #[Override]
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Data\DataTransferObjects';
    }
}
