<?php

namespace App\Repositories\Admin;

use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;
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

        return $settings ;
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



    public function ChangeActiveHomePage($request)
    {
        $Setting =  Setting::first();
        $Setting->update([
            'active_home_page' => $request->active_home_page,
        ]);
    }

}

