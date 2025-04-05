<?php

namespace App\Http\Controllers;

use App\Events\PackageSent;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;

class HomeController extends Controller
{
    public function index()
    {
        mongo_info('view', ['ip' => request()->ip(), 'url' => request()->url()], true);

        // test jobs, ...
        try {
            PackageSent::dispatch('processed', 'prosper');
            PackageSent::dispatch('delivered', 'olamide');

            $this->sendEmail();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return view('welcome');
    }

    private function sendEmail(): void
    {
        $emailService = new EmailService;
        $details = [
            'subject' => 'test',
            'body' => 'test',
        ];
        $emailService->setDetails($details);
        $emailService->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $emailService->setSubject('test');
        $emailService->setTo('test@example.com');
        $emailService->setEmailFiles([]);
        $messagesService = new MessageService($emailService);
        $messagesService->send();
    }
}
