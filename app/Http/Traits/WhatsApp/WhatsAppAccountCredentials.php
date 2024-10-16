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

            $message = sprintf(
            "%s,\n\n%s\n\n%s: %s\n%s: %s\n\n%s\n\n%s: %s",
            $user->name,
            __('Your new account has been created successfully. Here are your login details:'),
            __('Email'), $user->email,
            __('password'), $password,
            __('Please log in and change your password as soon as possible.'),
            __('login'), env('APP_URL')
        );

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
                            'phone' => 201205693178,
                            'type' => $whatsAppSetting->type,
                            'message' => $message,
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

