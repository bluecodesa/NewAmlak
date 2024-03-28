<?php
// app/Services/RegionService.php

namespace App\Services\Admin;

use App\Models\EmailSetting;

class EmailSettingService
{
    public function getAll()
    {
        return EmailSetting::first();
    }
}