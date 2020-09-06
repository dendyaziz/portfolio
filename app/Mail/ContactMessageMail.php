<?php

namespace App\Mail;

use App\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    protected $email;
    protected $message;

    /**
     * Create a new message instance.
     *
     * @param ContactMessage $contactMessage
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->name = $contactMessage->name;
        $this->email = $contactMessage->email;
        $this->message = $contactMessage->message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Portfolio: Mail from $this->name")
            ->view('vendor.mail.pickup-schedule-created');
    }
}
