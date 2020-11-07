<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $email;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @param $email
     * @param $subject
     * @param $content
     */
    public function __construct($email, $subject, $content)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email ?? config('app.mail'))
            ->subject($this->subject)
            ->view('mails.contact')->with([
                'content' => $this->content,
                'email' => $this->email,
                'subject' => $this->subject,
            ]);
    }
}
