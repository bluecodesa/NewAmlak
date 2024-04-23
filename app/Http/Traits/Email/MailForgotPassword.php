<?php

namespace App\Http\Traits\Email;

use App\Email\Admin\ForgotPassword;
use App\Models\Broker;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait MailForgotPassword
{
    public function MailForgotPassword($email, $code)
    {
        $notification_id = DB::table('notification_settings')->where('notification_name', 'Forget_Password')->where('email',1)->value('id');
        $EmailTemplate =  EmailTemplate::where('notification_setting_id', $notification_id)->first();
        $user = User::where('email', $email)->first();
        if ($EmailTemplate) {
            $subject =  $EmailTemplate->subject;
            $data['variable_owner_name'] = '';
            $data['variable_tenant_name'] = '';
            $data['variable_building_name'] = '';
            $data['variable_flat_no'] = '';
            $data['variable_agreement_id'] = '';
            $data['variable_agreement_expire_date'] = '';
            $data['variable_settel_date'] = '';
            $data['variable_verification_code'] = $code;
            $data['variable_broker_name'] = $user->UserBrokerData->name != null ? $user->UserBrokerData->name : "";
            // $data['variable_broker_name'] = $user->name != null ? $user->name : "";
            // $email = $user->email;
            $content = $EmailTemplate->content;
            foreach ($data as $key => $value) {
                $placeholder = '$data[' . $key . ']';
                $content = str_replace($placeholder, $value, $content);
            }
            try {
                Mail::to($email)->send(new ForgotPassword($data, $content, $subject, $EmailTemplate, $code)); // Pass $code to ForgotPassword Mailable
            } catch (\Throwable $th) {
                // Handle exceptions
            }
        }
    }
}
