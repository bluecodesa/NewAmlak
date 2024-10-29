<?php

namespace App\Http\Traits\WhatsApp;

use App\Models\WhatsAppSetting;
use App\Models\WhatsappTemplate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

trait WhatsAppAccountCredentials
{
    public function WhatsAppAccountCredentials($user, $password)
    {
        $whatsAppSetting = WhatsAppSetting::first();

        //     $message = sprintf(
        //     "%s,\n\n%s\n\n%s: %s\n%s: %s\n\n%s\n\n%s: %s",
        //     $user->name,
        //     __('Your new account has been created successfully. Here are your login details:'),
        //     __('Email'), $user->email,
        //     __('password'), $password,
        //     __('Please log in and change your password as soon as possible.'),
        //     __('login'), env('APP_URL')
        // );

        $notification_id = DB::table('notification_settings')
        ->where('notification_name', 'Add_new_tenant')
        ->where('whatsapp', 1)
        ->value('id');
        $whatsappTemplate = WhatsappTemplate::where('notification_setting_id', $notification_id)->first();

        if (!$whatsAppSetting) {
            return 'No WhatsApp settings found for this user';
        }

        if ($whatsappTemplate) {
            $plainContent = strip_tags($whatsappTemplate->content, '<br><p>');
            $plainContent = preg_replace('/<br\s*\/?>/i', "\n", $plainContent);
            $plainContent = preg_replace('/<\/p>/i', "\n\n", $plainContent);
            $plainContent = preg_replace('/<p[^>]*>/i', '', $plainContent);
            $plainContent = html_entity_decode($plainContent);
       // إعداد البيانات التي سيتم استبدالها
            $data['variable_home'] = env('APP_URL');
            $data['variable_login'] = route('Admin.home');
            $data['variable_broker_name'] = $user->name != null ? $user->name : "";
            $data['variable_subscriber_name'] = $user->name != null ? $user->name : "";
            $data['variable_subscriber_email'] = $user->email != null ? $user->email : "";
            $data['variable_subscriber_password'] = $password;



            // استبدال المتغيرات في النص
            foreach ($data as $key => $value) {
                // قم باستبدال المتغيرات داخل النص
                $placeholder = '$data[' . $key . ']';
                $plainContent = str_replace($placeholder, $value, $plainContent);
            }


            $client = new Client();

            try {
                $response = $client->post(
                    $whatsAppSetting->url,
                    [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $whatsAppSetting->api_key,
                            'Content-Type' => 'application/json',
                            'Accept' => 'application/json',
                        ],
                        'json' => [
                            'session_uuid' => $whatsAppSetting->session_uuid,
                            // 'phone' => $user->phone,
                            'phone' => 201119978333,
                            // 'phone' => 201205693178,
                            'type' => $whatsAppSetting->type,
                            'message' => $plainContent,
                            'schedule_at' => now(),
                        ],
                    ]
                );

                return $response->getBody()->getContents();
            } catch (\Throwable $th) {
                // Handle any errors that occur during the request
                return 'Error sending WhatsApp message: ' . $th->getMessage();
            }
        }
    }

}
