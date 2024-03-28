<?php

namespace App\Email\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeBroker extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $content;
    public $subject;
    public $EmailTemplate;


    public function __construct($data, $content, $subject, $EmailTemplate)
    {
        $this->data = $data;
        $this->content = $content;
        $this->subject = $subject;
        $this->EmailTemplate = $EmailTemplate;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.Admin.WelcomeBroker');
    }
}
