<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserCodeResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contactinfo@excellis.co.in', 'Standing On The Rock')
            ->subject('Password Reset Link - ' . config('app.name'))
            ->markdown('frontend.emails.SendUserCodeResetPassword')
            ->with('details', $this->details)
            ->text('frontend.emails.SendUserCodeResetPassword_plain'); // Add a plain text alternative
    }
}
