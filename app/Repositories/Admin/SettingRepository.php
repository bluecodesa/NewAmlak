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
        // Implement logic to update a setting
    }

    public function createSetting(array $data)
    {
        // Implement logic to create a new setting
    }

    public function findSettingById(int $id)
    {
        // Implement logic to find a setting by its ID
    }

    public function deleteSetting($id)
    {
        // Implement logic to delete a setting
    }

    public function updatePaymentSetting(array $data)
    {
        // Implement logic to update a setting
    }

    public function createPaymentSetting(array $data)
    {
        // Implement logic to create a new setting
    }
}

