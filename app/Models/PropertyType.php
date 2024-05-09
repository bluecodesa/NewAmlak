<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use Translatable;
    public $translatedAttributes = ['name'];
    protected $guarded = [];

    public function PropertyData()
    {
        return $this->hasMany(Property::class, 'property_type_id');
    }

    public function UnitData()
    {
        return $this->hasMany(Unit::class, 'property_type_id');
    }
}