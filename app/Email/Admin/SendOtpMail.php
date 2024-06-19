<?php

namespace App\Email\Admin;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $content;
    public $subject;
    public $EmailTemplate;
    public $code;


    public function __construct($data, $content, $subject, $EmailTemplate, $code) // Add $code parameter
    {
        $this->data = $data;
        $this->content = $content;
        $this->subject = $subject;
        $this->EmailTemplate = $EmailTemplate;
        $this->code = $code;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your OTP for Property Finder Registration')
                    ->view('emails.Home.sendOtpMail')->with(['code' => $this->code]);
    }
}

