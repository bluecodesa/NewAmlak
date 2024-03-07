<?php

namespace App\Interfaces\Broker;

use App\Models\Broker;
use App\Models\Setting;
use Illuminate\Http\Request;


interface SettingRepositoryInterface
{
    public function getBrokerSettings($broker);

    public function createSetting(array $data);
    public function findSettingById(int $id);
    public function deleteSetting($id);
    public function updateBroker(array $data, Broker $broker);
    public function NotificationToggleSetting($data, $id);
    public function UpdateEmailSetting($data);
    public function getNotificationSetting();
}
