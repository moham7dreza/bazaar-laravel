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
use Illuminate\Support\Arr;

class UserLandMail extends Mailable implements ShouldQueue
{
    use Queueable;

    use SerializesModels;

    public function __construct(
        public $subject,
        public $from,
        public $details,
        public $files = [],
    ) {
        $this->onQueue(Queue::Mail);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(Arr::get($this->from, '0.address'), Arr::get($this->from, '0.name')),
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'subject' => Arr::get($this->details, 'subject'),
                'body'    => Arr::get($this->details, 'body'),
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
