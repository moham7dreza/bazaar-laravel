<?php

namespace App\Http\Controllers;

use Amiriun\SMS\DataContracts\SentSMSOutputDTO;
use Amiriun\SMS\Services\SMSService;
use App\Events\PackageSent;
use App\Mail\UserLandMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function fallbackHandler()
    {
        Log::error('error 404 '.date('Y-m-d H:i:s')."\r\ncurrent: ".url()->current()."\r\nprevious: ".url()->previous()."\r\n\r\n");

        return response()->view('errors.404', [], 404);
    }

    public function index()
    {
        mongo_info('view', ['ip' => request()->ip(), 'url' => request()->url()], true);

        // test jobs, ...
        try {
            PackageSent::dispatch('processed', 'prosper');
            PackageSent::dispatch('delivered', 'olamide');

            //            $this->sendEmail();
            $this->sendSms();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return view('welcome');
    }

    private function sendEmail(): void
    {
        Mail::to('test@example.com')->send(new UserLandMail(
            subject: 'welcome',
            from: getenv('MAIL_FROM_ADDRESS'),
            details: [
                'subject' => 'test',
                'body' => 'test',
            ],
            files: [],
        ));
    }

    private function sendSms(): SentSMSOutputDTO
    {
        $data = new \Amiriun\SMS\DataContracts\SendSMSDTO;
        $data->setSenderNumber('300024444'); // also this can be set as default in config/sms.php
        $data->setMessage('Hello, this is a test');
        $data->setTo('09123000000');

        return app(SMSService::class)->send($data);
    }
}
