<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject, $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body)
    {
        //
        $this->subject = $subject;
        $this->body = $body;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $site = env('FRONT_ADMIN_APP_URL')."/Login";
        $logo = env('APP_LOGO');
        return $this->from('miendjemthierry01@gmail.com', 'Example')
            ->subject($this->subject)
            ->view('email.basic')->with('logo', $logo)->with('body', $this->body)->with('site', $site);
    }
}
