<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Amiriun\SMS\Services\SMSService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

final class HomeController extends Controller
{
    public function __invoke(Request $request, SMSService $SMSService)
    {
        Log::warning('this is sample log to view queued jobs [{date}]', ['date' => Date::now()->toDateTimeString()]);

        return new JsonResponse([
            'ServiceName'    => sprintf('%s %s', config()->string('app.name'), 'Api'),
            'ServiceVersion' => 'v1.0',
            'HostName'       => $request->getHost(),
            'Time'           => Date::now()->toDateTimeString(),
            'Status'         => 'healthy',
        ]);
    }
}
