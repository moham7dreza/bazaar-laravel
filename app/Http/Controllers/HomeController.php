<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Amiriun\SMS\Services\SMSService;
use App\Enums\Sms\SmsSenderNumber;
use App\Events\PackageSent;
use App\Helpers\JalalianFactory;
use App\Mail\UserLandMail;
use Exception;
use Illuminate\Http\Client\Batch;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function __invoke(SMSService $SMSService)
    {
        defer(static function () use ($SMSService): void {
            mongo_info('view', ['ip' => request()->ip(), 'url' => request()->url()], true);

            try
            {
                // sample jobs, ...
                event(new PackageSent('processed', 'prosper'));
                event(new PackageSent('delivered', 'olamide'));

                // sample send sms
                $data = new \Amiriun\SMS\DataContracts\SendSMSDTO();
                $data->setSenderNumber(SmsSenderNumber::NUMBER_2->value); // also this can be set as default in config/sms.php
                $data->setMessage('Hello, this is a test');
                $data->setTo('09123000000');
                $SMSService->send($data);

                // sample send email
                Mail::to('test@example.com')
//                    ->when(false)
                    ->send(new UserLandMail(
                        subject: 'welcome',
                        from: getenv('MAIL_FROM_ADDRESS'),
                        details: [
                            'subject' => 'test',
                            'body'    => 'test',
                        ],
                        files: [],
                    ));

            } catch (Exception $e)
            {
                Log::error($e->getMessage());
            }
        });

        Log::warning('this is sample log to view queued jobs [{date}]', ['date' => now()->jdate()->format('Y-m-d H:i:s')]);

        // sample http batch requests
        Http::batch(
            callback: fn (Batch $batch) => [
                $batch->get(config()->string('app.frontend_url')),
                $batch->get(config()->string('app.url')),
                $batch->get(config()->string('app.url') . '/super-admin'),
            ],
        )->then(function (Batch $batch, array $results): void {
            logger('sample http batch request results', [
                'results' => $results,
            ]);
        })->defer();

        return response()->json([
            'ServiceName'    => 'Bazaar Api',
            'ServiceVersion' => 'v1.0',
            'HostName'       => \request()?->getHost(),
            'Time'           => JalalianFactory::now()->toDateTimeString(),
            'Status'         => 'healthy',
        ]);
    }
}
