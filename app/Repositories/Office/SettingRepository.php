<?php

namespace App\Repositories\Office;

use App\Models\Gallery;
use App\Models\Setting;
use App\Interfaces\Office\SettingRepositoryInterface;
use App\Models\Office;
use App\Models\EmailSetting;
use App\Models\NotificationSetting;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SettingRepository implements SettingRepositoryInterface
{

    public function getOfficeSettings( $office)
    {
        $subscription = Subscription::where('office_id', $office->id)->first();
        $gallery = Gallery::where('office_id', $office->id)->first();
        $notificationSettings = NotificationSetting::all();
        $user = Auth::user()->UserOfficeData->userData;
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




    public function updateOffice(array $data, $id)
    {

            $office = Office::findOrFail($id);
            $office->update($data);
            return $office;
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
