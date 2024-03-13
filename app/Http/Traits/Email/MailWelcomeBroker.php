<?php

namespace App\Http\Traits\Email;

use App\Email\Admin\WelcomeBroker;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

trait MailWelcomeBroker
{
    public function MailWelcomeBroker($user, $subscription, $subscriptionType, $Invoice)
    {

        $notification_id = DB::table('notification_settings')->where('notification_name', 'Real_estate_marketer_welcome_email')->value('id');
        $EmailTemplate =  EmailTemplate::where('notification_setting_id', $notification_id)->first();
        if ($EmailTemplate) {
            $subject =  $EmailTemplate->subject;
            $data['variable_owner_name'] = '';
            $data['variable_tenant_name'] = '';
            $data['variable_building_name'] = '';
            $data['variable_flat_no'] = '';
            $data['variable_agreement_id'] = '';
            $data['variable_agreement_expire_date'] = '';
            $data['variable_settel_date'] = '';
            $data['variable_date_of_payment'] = $subscription->start_date ?? null;
            $data['variable_payment_amount'] = $Invoice->amount ?? null;
            $data['variable_broker_name'] = $user->name != null ? $user->name : "";
            $data['variable_subscriber_name'] = $subscriptionType->name != null ? $subscriptionType->name : "";
            $data['variable_current_subscription'] = $subscriptionType->name != null ? $subscriptionType->name : "";
            $data['variable_subscription_invoice_number'] = $Invoice->invoice_ID ?? null;
            $data['variable_subscription_invoice_download_link'] = env('APP_URL');
            $email = $user->email;
            $content = $EmailTemplate->content;
            foreach ($data as $key => $value) {
                $placeholder = '$data[' . $key . ']';
                $content = str_replace($placeholder, $value, $content);
            }
            try {
                Mail::to($email)->send(new WelcomeBroker($data, $content, $subject, $EmailTemplate));
            } catch (\Throwable $th) {
            }
        }
    }
}
