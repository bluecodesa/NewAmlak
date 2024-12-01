<?php

namespace App\Interfaces\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;


interface SettingRepositoryInterface
{
    public function getAllSetting();
    public function getFirstSetting();

    public function updateSetting(Setting $setting, array $data);
    public function createSetting(array $data);
    public function findSettingById(int $id);
    public function deleteSetting($id);
    public function ChangeActiveHomePage($data);
    public function NotificationToggleSetting($data, $id);
    public function UpdateEmailSetting($data);
    public function getSetting();
    public function getNotificationSetting();

    public function getAllInterestTypes();
    public function createInterestType($data);
    public function getInterestTypeById($data);
    public function updateInterestType($id, $data);
    public function deleteInterestType($id);
}
