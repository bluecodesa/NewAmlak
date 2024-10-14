<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppSetting extends Model
{
    use HasFactory;
    protected $table = 'whatsapp_settings';

    protected $guarded = [];

    public function UserData()
    {
        return $this->belongsTo(User::class);
    }
}
