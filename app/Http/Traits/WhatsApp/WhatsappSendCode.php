<?php

namespace App\Http\Traits\WhatsApp;

use Illuminate\Support\Facades\Auth;
use MacsiDigital\Zoom\Facades\Zoom;

trait WhatsappSendCode
{
    public function WhatsappSendCode($data)
    {

        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post(
                'https://cloudwa.net/api/v2/messages/send-message',
                [
                    'headers' => [
                        'Authorization' => 'Bearer 41|1r3C8pTrV86ueXNTc2PB3sqI5fmCLUD7RytOGjTc',
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],

                    'json' => [
                        'session_uuid' => env('session_uuid', '9d33ea64-45e7-4dc2-87fb-66ec4ff15956'),
                        'phone' => $data['phone'],
                        'type' => 'TEXT',
                        'message' => __('Your OTP code is') . ' : ' . $data['otp'],
                        'schedule_at' => now(),
                    ],
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
