<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $guarded = [];

    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}