<?php

namespace App\Http\Traits\WhatsApp;

use App\Models\WhatsAppSetting;
use App\Models\WhatsappTemplate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

trait WhatsappSendCode
{
    public function WhatsappSendCode($data)
    {
        $whatsAppSetting = WhatsAppSetting::first();

        $notification_id = DB::table('notification_settings')->where('notification_name', 'add-new-property-finder')->where('whatsapp',1)->value('id');
        $whatsappTemplate = WhatsappTemplate::where('notification_setting_id', $notification_id)->first();
    if (!$whatsAppSetting) {
        return 'No WhatsApp settings found for this user';
    }

        if ($whatsappTemplate) {


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
                            'phone' => $data['phone'],
                            'type' => $whatsAppSetting->type,
                            'message' => __($whatsappTemplate->content) . __('This is the OTP code:') . $data['otp'],
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
