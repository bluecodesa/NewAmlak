<?php

namespace App\Interfaces\Admin;

use App\Models\Setting;

interface SettingRepositoryInterface
{
    public function getAllSetting(): Setting;
    public function updateWebsiteSetting(array $data, Setting $setting): Setting;

}

