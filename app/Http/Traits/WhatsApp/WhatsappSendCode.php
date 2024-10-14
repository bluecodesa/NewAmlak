<?php

namespace App\Http\Traits\WhatsApp;

use App\Models\WhatsAppSetting;
use GuzzleHttp\Client;

trait WhatsappSendCode
{
    public function WhatsappSendCode($data)
    {
        $whatsAppSetting = WhatsAppSetting::first();

        if (!$whatsAppSetting) {
            return 'No WhatsApp settings found for this user';
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
                        'phone' => $data['phone'],
                        'type' => $whatsAppSetting->type,
                        'message' => __('Welcome Your OTP code is') . ' : ' . $data['otp'],
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
