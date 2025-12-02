<?php

declare(strict_types=1);

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImageController;
use App\Models\NotificationLog;
use App\Models\Scopes\LatestScope;
use App\Models\Scopes\WithDeletedRecordsScope;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Monitoring\Models\CommandPerformanceLog;
use Modules\Monitoring\Models\DevLog;
use Modules\Monitoring\Models\JobPerformanceLog;

arch()
    ->expect('App')
    ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

arch()
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend(Model::class)
//    ->toOnlyBeUsedIn('App\Repositories')
    ->ignoring([
        LatestScope::class,
        WithDeletedRecordsScope::class,
    ]);

arch()
    ->expect('App\Http\Controllers')
    ->toBeClasses()
    ->toExtend(Controller::class);

arch()
    ->expect('App\Enums')
    ->toBeEnums();

arch('globals')
    ->expect(['dd', 'dump'])
    ->not->toBeUsed();

// arch('facades')
//    ->expect('Illuminate\Support\Facades')
//    ->not->toBeUsed();

arch()
    ->expect('App\Jobs')
    ->toImplement(ShouldQueue::class);

arch()
    ->expect('App')
    ->not->toHaveFileSystemPermissions('0777');

arch()
    ->expect('App\Models')
    ->toHaveLineCountLessThan(1000);

arch()
    ->expect('App\Helpers')
    ->not->toHavePrefix('Helper');

// arch()
//    ->expect('App\Models')
//    ->toOnlyUse('Illuminate\Database');

arch()
    ->expect(ImageController::class)
    ->toHaveMethods(['store', 'update']);

arch()
    ->expect('App')
    ->not->toUseStrictEquality();

arch()
    ->expect('App')
    ->toUseStrictEquality();

arch()
    ->expect('App\Models')
    ->toUseTrait(SoftDeletes::class)
    ->ignoring([
        CommandPerformanceLog::class,
        JobPerformanceLog::class,
        DevLog::class,
        SmsLog::class,
        NotificationLog::class,
        User::class,
    ]);

 arch()
     ->expect('App')
     ->toUseStrictTypes();

arch()->preset()->laravel();
arch()->preset()->php();
// arch()->preset()->strict();
// arch()->preset()->relaxed();
arch()->preset()->security()->ignoring('md5');
