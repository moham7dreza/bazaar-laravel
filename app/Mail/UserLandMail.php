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
            from: new Address($this->from[0]['address'], $this->from[0]['name']),
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail',
            with: [
                'subject' => $this->details['subject'],
                'body'    => $this->details['body'],
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
