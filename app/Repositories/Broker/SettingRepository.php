<?php

namespace App\Repositories\Broker;

use App\Models\Gallery;
use App\Models\Setting;
use App\Interfaces\Broker\SettingRepositoryInterface;
use App\Models\Broker;
use App\Models\EmailSetting;
use App\Models\NotificationSetting;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SettingRepository implements SettingRepositoryInterface
{



    
    public function createSetting(array $data)
    {
    }

    public function findSettingById(int $id)
    {
    }

    public function deleteSetting($id)
    {
    }


    public function getBrokerSettings(Broker $broker)
    {
        $subscription = Subscription::where('broker_id', $broker->id)->first();
        $gallery = Gallery::where('broker_id', $broker->id)->first();
        $notificationSettings = NotificationSetting::all();
        $user = Auth::user()->UserBrokerData->userData;

        return compact('subscription', 'gallery', 'notificationSettings','user');
    }

    public function updateBroker(array $data, Broker $broker)
    {
        // Update broker data here
    }



  
    public function NotificationToggleSetting($data, $id)
    {
        NotificationSetting::where('id', $id)->update([
            $data['type'] => $data['valu']
        ]);
    }

    function UpdateEmailSetting($data)
    {
        EmailSetting::updateOrCreate(['host' => $data['host']], ['host' => $data['host'], 'port' => $data['port'], 'user_name' => $data['user_name'], 'name' => $data['name'], 'password' => $data['password']]);
    }

  

    public function getNotificationSetting()
    {
        return NotificationSetting::all();
    }
}