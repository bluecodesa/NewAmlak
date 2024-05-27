<?php

namespace App\Services;

use App\Models\Broker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewBrokerNotification;


class BrokerCreationService
{
    public function createBroker(array $brokerData, User $user)
    {

        $broker = Broker::create([
            'user_id' => $user->id,
            'broker_license' => $brokerData['license_number'],
            'key_phone' => $brokerData['key_phone'],
            'mobile' => $brokerData['mobile'],
            'full_phone' => $brokerData['full_phone'],
            'city_id' => $brokerData['city_id'],
            'id_number' => $brokerData['id_number'],
            'broker_logo' => $brokerData['broker_logo'] ?? null,
        ]);


        return $broker;
    }
}