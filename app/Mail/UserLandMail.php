<?php

declare(strict_types=1);

namespace App\Mail;

use App\Enums\Queue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserLandMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public $subject,
        public $from,
        public $details,
        public $files = [],
    ) {
        $this->onQueue(Queue::MAIL);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(\Illuminate\Support\Arr::get($this->from, '0.address'), \Illuminate\Support\Arr::get($this->from, '0.name')),
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'subject' => \Illuminate\Support\Arr::get($this->details, 'subject'),
                'body'    => \Illuminate\Support\Arr::get($this->details, 'body'),
            ]
        );
    }

    public function attachments(): array
    {
        $publicFiles = [];
        foreach ($this->files as $file)
        {
            $publicFiles[] = public_path($file);
        }

        return $publicFiles;
    }
}
