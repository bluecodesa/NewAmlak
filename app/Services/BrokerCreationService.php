<?php

namespace App\Services;

use App\Models\Broker;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Admin\NewOfficeNotification;


class BrokerCreationService
{
    public function createBroker(array $brokerData, User $user)
    {

        $broker = Broker::create([
            'user_id' => $user->id,
            'broker_license' => $brokerData['license_number'],
            'mobile' => $brokerData['mobile'],
            'city_id' => $brokerData['city_id'],
            'id_number' => $brokerData['id_number'],
        ]);

        return $broker;
    }

}