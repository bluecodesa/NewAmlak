<?php

namespace App\Repositories\Admin;

use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Models\EmailSetting;
use App\Models\InterestType;
use App\Models\NotificationSetting;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Request;

class SettingRepository implements SettingRepositoryInterface
{
    public function getAllSetting()
    {
        $settings = Setting::first();
        $paymentGateways = PaymentGateway::all();

        if (!$settings) {
            $settings = new Setting();
        }
        $settings->paymentGateways = $paymentGateways;

        return $settings;
    }

    public function getFirstSetting()
    {
        return Setting::first();
    }
    public function updateSetting(Setting $setting, array $data)
    {
        $setting->update($data);
        return $setting;
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


    public function createPaymentSetting(array $data)
    {
    }
    public function updatePaymentSetting(array $data)
    {
    }

    public function createAds($request)
    {
        $validatedData = $request->validate([
            'google_tag' => 'nullable|string',
            'zoho_salesiq' => 'nullable|string',
        ]);
    
        $setting = Setting::first();
    
        $setting->update([
            'google_tag' => $validatedData['google_tag'],
            'zoho_salesiq' => $validatedData['zoho_salesiq'],
        ]);
    }

    public function ChangeActiveHomePage($request)
    {
        $Setting =  Setting::first();
        $Setting->update([
            'active_home_page' => $request->active_home_page,
        ]);
    }

    public function ChangeActiveGalleryPage($request)
    {
        $Setting =  Setting::first();
        $Setting->update([
            'active_gallery' => $request->active_gallery,
        ]);
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

    public function getSetting()
    {
        return Setting::first();
    }

    public function getNotificationSetting()
    {
        return NotificationSetting::all();
    }

    public function getAllInterestTypes()
    {

        return InterestType::paginate(100);
    }

    public function createInterestType($data)
    {
        return InterestType::create($data);
    }

    function getInterestTypeById($id)
    {
        return InterestType::find($id);
    }

    public function updateInterestType($id, $data)
    {
        $Interest = InterestType::findOrFail($id);
        $Interest->update($data);
        return $Interest;
    }

    public function deleteInterestType($id)
    {
        return InterestType::findOrFail($id)->delete();
    }
}
