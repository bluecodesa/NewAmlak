<?php

namespace App\Interfaces\Admin;

use App\Models\Setting;

interface SettingRepositoryInterface
{
    public function getAllSetting();
    public function updateSetting(array $data);
    public function createSetting(array $data);
    public function findSettingById(int $id);
    public function deleteSetting($id);
}

