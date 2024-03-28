<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = [];


    public function RegionData()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }


    public function DistrictsCity()
    {
        return $this->hasMany(District::class, 'city_id');
    }
}