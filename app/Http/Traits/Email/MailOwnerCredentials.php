<?php

namespace App\Http\Traits\Email;

use App\Email\Admin\OwnerCredentials;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait MailOwnerCredentials
{
    public function MailOwnerCredentials($user, $password)
    {


        $notification_id = DB::table('notification_settings')
        ->where('notification_name', 'Add_new_tenant')
        ->where('email', 1)
        ->value('id');
        $EmailTemplate =  EmailTemplate::where('notification_setting_id', $notification_id)->first();
        if ($EmailTemplate) {
            $subject =  $EmailTemplate->subject;
            $data['variable_home'] = env('APP_URL');
            $data['variable_login'] = route('Admin.home');
            $data['variable_broker_name'] = $user->name != null ? $user->name : "";
            $data['variable_subscriber_name'] = $user->name != null ? $user->name : "";
            $data['variable_subscriber_email'] = $user->email != null ? $user->email : "";
            $data['variable_subscriber_password'] = $password;
            $email = $user->email;
            $content = $EmailTemplate->content;
            foreach ($data as $key => $value) {
                $placeholder = '$data[' . $key . ']';
                $content = str_replace($placeholder, $value, $content);
            }
            // Mail::to($email)->send(new WelcomeBroker($data, $content, $subject, $EmailTemplate));
            try {
                Mail::to($user->email)->send(mailable: new OwnerCredentials($user, $password));
            } catch (\Throwable $th) {
            }


    }
}
}
