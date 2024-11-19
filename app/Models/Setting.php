<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'terms', 'privacy' ,'terms_advertising'];
    protected $guarded = [];
    protected $appends = ['full_phone'];


    public function getFullPhoneAttribute(): string
    {
        return $this->key_support_phone . $this->support_phone;
    }
}
