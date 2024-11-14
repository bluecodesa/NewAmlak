<?php
// app/Services/RegionService.php

namespace App\Services\Admin;

use App\Models\EmailSetting;
use App\Models\WhatsAppSetting;

class EmailSettingService
{
    public function getAll()
    {
        return EmailSetting::first();
    }
    public function getAllWhatsApp()
    {
        return WhatsAppSetting::first();
    }
}
