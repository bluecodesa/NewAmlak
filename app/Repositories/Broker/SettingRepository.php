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

    public function getBrokerSettings( $broker)
    {
        $subscription = Subscription::where('broker_id', $broker->id)->first();
        $gallery = Gallery::where('broker_id', $broker->id)->first();
        $notificationSettings = NotificationSetting::all();
        $user = Auth::user()->UserBrokerData->userData;
        return get_defined_vars();
    }



    public function createSetting(array $data)
    {
    }

    public function findSettingById(int $id)
    {
    }

    public function deleteSetting($id)
    {
    }




    public function updateBroker(array $data, $id)
    {

            $broker = Broker::findOrFail($id);
            $broker->update($data);
            return $broker;
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
