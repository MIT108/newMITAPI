<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $subject, $receiverEmail, $receiverName, $body;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $receiverEmail, $receiverName)
    {
        //
        $this->subject = $subject;
        $this->body = $body;
        $this->receiverEmail = $receiverEmail;
        $this->receiverName = $receiverName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        app('App\Http\Controllers\EmailController')->sendMail($this->subject, $this->body, $this->receiverEmail, $this->receiverName);
    }
}
