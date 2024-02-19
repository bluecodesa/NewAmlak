<?php

namespace App\Http\Traits\notification;

use App\Models\User;

trait FiresendNotification
{

    public function FiresendNotification($data, $ids)
    {
        $firebaseToken = User::whereIn('id', $ids)->whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $SERVER_API_KEY = 'AAAA_n9tdtk:APA91bGK2l8m4jVCC-v1fkSJT7l2IvGfsOSwYXPi-mOwPWO1-3ct0JSyjGBic6oAW8tH42-NSW18JYO_xeKNmhD2xPxIYb9cGMjIcakwssBxW1qQiW4OQ90kPfM3DjX--FR42aitopTp';

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $data['title'],
                "body" => $data['body'],
                "content_available" => true,
                "priority" => "high",
            ],
            "data" => [
                "url" => $data['url'], // Add the URL to the data payload
            ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
    }
}