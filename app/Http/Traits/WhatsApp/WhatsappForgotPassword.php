<?php

namespace App\Http\Traits\WhatsApp;

use App\Models\WhatsAppSetting;
use App\Models\WhatsappTemplate;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

trait WhatsappForgotPassword
{
    public function WhatsappForgotPassword($phone, $code)
    {
        $whatsAppSetting = WhatsAppSetting::first();

        // Get the WhatsApp template for the specific notification
        $notification_id = DB::table('notification_settings')
            ->where('notification_name', 'Forget_Password')
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
                            'phone' => $phone,
                            'type' => $whatsAppSetting->type,
                            'message' => $plainContent . $code,
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