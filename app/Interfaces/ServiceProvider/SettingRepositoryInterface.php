<?php

namespace App\Interfaces\ServiceProvider;

use App\Models\Office;
use App\Models\Setting;
use Illuminate\Http\Request;


interface SettingRepositoryInterface
{
    public function getSetting($serviceProvider);

    public function createSetting(array $data);
    public function findSettingById(int $id);
    public function deleteSetting($id);
    public function updateOffice(array $data, $id);
    public function NotificationToggleSetting($data, $id);
    public function UpdateEmailSetting($data);
    public function getNotificationSetting();
}
