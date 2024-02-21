<?php

namespace App\Repositories\Admin;

use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Models\PaymentGateway;

class SettingRepository implements SettingRepositoryInterface
{
    public function getAllSetting(): Setting
    {
        $settings = Setting::first();
        $paymentGateways = PaymentGateway::all();


        if (!$settings) {
            $settings = new Setting();
        }
        $settings->paymentGateways = $paymentGateways;

        return $settings ;
    }

    public function updateWebsiteSetting(array $data, Setting $setting): Setting
    {
        $setting->save();
        return $setting;
    }
}
