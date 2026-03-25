<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The reset URL for password reset.
     *
     * @var string
     */
    public $resetUrl;
    public $token;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param  string  $resetUrl
     * @param  string  $token
     * @param  string  $email
     * @return void
     */
    public function __construct($resetUrl, $token, $email)
    {
        $this->resetUrl = $resetUrl;
        $this->token = $token;
        $this->email = $email;
    }
    
        /**
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            return $this->view('emails.reset_password')->with([
                'token' => $this->token,   
                'email' => $this->email    
            ]);
        }
    }

