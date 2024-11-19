<?php

namespace App\Http\Traits\WhatsApp;

use App\Models\WhatsAppSetting;
use App\Models\WhatsappTemplate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

trait WhatsappActivateSubscription
{
    public function WhatsappActivateSubscription($user, $subscription, $subscriptionType, $invoice)
    {
        $whatsAppSetting = WhatsAppSetting::first();

        // Get the WhatsApp template for the specific notification

        $notification_id = DB::table('notification_settings')
        ->where('notification_name', 'activate-subscription')
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
            $data['variable_subscriber_name'] = $user->name != null ? $user->name : "";;
            $data['variable_current_subscription']=$subscriptionType->name;
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
                            // 'phone' => $user->full_phone,
                            // 'phone' => 201119978333,
                            'phone' => 201205693178,
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
