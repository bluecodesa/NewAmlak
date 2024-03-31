<?php

namespace App\Email\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
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

    public function build()
    {
        return $this->subject($this->subject)
        ->view('emails.Admin.password_code')
        ->with(['code' => $this->code]);
    }
}
