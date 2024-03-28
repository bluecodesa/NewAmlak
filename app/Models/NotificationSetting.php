<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    protected $guarded = [];

    public function EmailTemplateData()
    {
        return $this->hasOne(EmailTemplate::class, 'notification_setting_id');
    }
}