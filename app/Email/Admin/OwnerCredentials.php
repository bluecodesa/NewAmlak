<?php

namespace App\Email\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OwnerCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $data;
    public $content;
    public $subject;
    public $EmailTemplate;


    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string  $password
     * @return void
     */
    public function __construct($data, $content, $subject, $EmailTemplate, $password)
    {
        $this->password = $password;
        $this->data = $data;
        $this->content = $content;
        $this->subject = $subject;
        $this->EmailTemplate = $EmailTemplate;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.Admin.OwnerCredentials');
    }
}
