<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappTemplate extends Model
{
    protected $table = 'whatsapp_templates';
    protected $guarded = [];

    public function NotificationData()
    {
        return $this->belongsTo(NotificationSetting::class, 'notification_setting_id');
    }
}
