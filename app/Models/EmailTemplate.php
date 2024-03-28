<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $guarded = [];

    public function NotificationData()
    {
        return $this->belongsTo(NotificationSetting::class, 'notification_setting_id');
    }
}
