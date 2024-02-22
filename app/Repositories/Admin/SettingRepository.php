<?php

namespace App\Repositories\Admin;

use App\Models\Setting;
use App\Interfaces\Admin\SettingRepositoryInterface;
use App\Models\PaymentGateway;

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

    public function updateWebsiteSetting(array $data, Setting $setting): Setting
    {
        $setting->save();
        return $setting;
    }


    public function updateSetting(array $data)
    {
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

    public function updatePaymentSetting(array $data)
    {
    }

    public function createPaymentSetting(array $data)
    {
    }
}

