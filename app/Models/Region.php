<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
