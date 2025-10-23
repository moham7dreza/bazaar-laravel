<?php

declare(strict_types=1);
//
//declare(strict_types=1);
//
//arch()
//    ->expect('App')
//    ->toUseStrictTypes()
//    ->not->toUse(['die', 'dd', 'dump']);
//
//arch()
//    ->expect('App\Models')
//    ->toBeClasses()
//    ->toExtend('Illuminate\Database\Eloquent\Model');
////    ->toOnlyBeUsedIn('App\Repositories')
////    ->ignoring('App\Models\User')
//
//arch()
//    ->expect('App\Http')
//    ->toOnlyBeUsedIn('App\Http');
//
//arch()
//    ->expect('App\Enums')
//    ->toBeEnums();
//
//arch('globals')
//    ->expect(['dd', 'dump'])
//    ->not->toBeUsed();
//
//// arch('facades')
////    ->expect('Illuminate\Support\Facades')
////    ->not->toBeUsed();
//
//arch()
//    ->expect('App\Jobs')
//    ->toImplement('Illuminate\Contracts\Queue\ShouldQueue');
//
//arch()
//    ->expect('App')
//    ->not->toHaveFileSystemPermissions('0777');
//
//arch()
//    ->expect('App\Models')
//    ->toHaveLineCountLessThan(100);
//
//arch()
//    ->expect('App\Helpers')
//    ->not->toHavePrefix('Helper');
//
//// arch()
////    ->expect('App\Models')
////    ->toOnlyUse('Illuminate\Database');
//
//arch()
//    ->expect('App\Http\Controllers\Image')
//    ->toHaveMethods(['store', 'update']);
//
//arch()
//    ->expect('App')
//    ->not->toUseStrictEquality();
//
//arch()
//    ->expect('App')
//    ->toUseStrictEquality();
//
//arch()
//    ->expect('App\Models')
//    ->toUseTrait('Illuminate\Database\Eloquent\SoftDeletes')
//    ->ignoring([
//        'Modules\Monitoring\Models\CommandPerformanceLog',
//        'Modules\Monitoring\Models\JobPerformanceLog',
//        'Modules\Monitoring\Models\DevLog',
//        'App\Models\Monitor\SmsLog',
//        'App\Models\Monitor\NotificationLog',
//        'App\Models\User',
//    ]);
//
//// arch()
////    ->expect('App')
////    ->toUseStrictTypes();
//
//arch()->preset()->laravel();
//arch()->preset()->php();
//// arch()->preset()->strict();
//// arch()->preset()->relaxed();
//arch()->preset()->security()->ignoring('md5');
