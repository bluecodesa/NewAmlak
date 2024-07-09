<?php

namespace App\Http\Traits\Email;

use App\Email\Admin\SendOtpMail;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait MailSendCode
{
    public function MailSendCode($email, $code)
    {
        $notification_id = DB::table('notification_settings')->where('notification_name', 'add-new-property-finder')->where('email',1)->value('id');
        $EmailTemplate =  EmailTemplate::where('notification_setting_id', $notification_id)->first();
        $user = User::where('email', $email)->first();
        if ($EmailTemplate) {
            $subject =  $EmailTemplate->subject;

            $data['otp'] = $code;
            // $data['variable_subscriber_name'] = $user->name != null ? $user->name : "";
            $content = $EmailTemplate->content;
            foreach ($data as $key => $value) {
                $placeholder = '$data[' . $key . ']';
                $content = str_replace($placeholder, $value, $content);
            }
            try {
                Mail::to($email)->send(new SendOtpMail($data, $content, $subject, $EmailTemplate, $code)); // Pass $code to ForgotPassword Mailable
            } catch (\Throwable $th) {
                // Handle exceptions
            }
        }
    }
}
