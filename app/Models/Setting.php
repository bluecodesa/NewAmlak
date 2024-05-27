<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];
    protected $guarded = [];
    protected $appends = ['full_phone'];


    public function getFullPhoneAttribute()
    {
        return $this->key_support_phone . $this->support_phone;
    }
}
