<?php

namespace App\Interfaces\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;


interface SettingRepositoryInterface
{
    public function getAllSetting();
    public function updateSetting(Setting $setting, array $data);
    public function createSetting(array $data);
    public function findSettingById(int $id);
    public function deleteSetting($id);
    public function ChangeActiveHomePage($data);
}

