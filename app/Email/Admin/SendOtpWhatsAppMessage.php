<?php

namespace App\Email\Admin;


use Illuminate\View\View;

class SendOtpWhatsAppMessage
{
    protected $data;
    protected $content;
    protected $subject;
    protected $template;
    protected $otp;

    public function __construct($data, $content, $subject, $template, $otp)
    {
        $this->data = $data;
        $this->content = $content;
        $this->subject = $subject;
        $this->template = $template;
        $this->otp = $otp;
    }

    // Function to render the WhatsApp message template
    public function render()
    {
        return view('whatsapp.sendWhatsAppOtpMessage', ['code' => $this->otp])->render();
    }
}
