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

        // Create a Guzzle client
        $client = new Client();

        try {
            // Make the request
            $response = $client->post(
                $whatsAppSetting->url, // URL from the database
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $whatsAppSetting->api_key,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],

                    'json' => [
                        'session_uuid' => $whatsAppSetting->session_uuid, // Use session UUID from database
                        'phone' => $data['phone'],
                        'type' => $whatsAppSetting->type,
                        'message' => __('Welcome Your OTP code is') . ' : ' . $data['otp'],
                        'schedule_at' => now(),
                    ],
                ]
            );

            // Handle the response if necessary
            return $response->getBody()->getContents();
        } catch (\Throwable $th) {
            // Handle any errors that occur during the request
            return 'Error sending WhatsApp message: ' . $th->getMessage();
        }
    }
}
