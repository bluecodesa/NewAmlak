<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = [];

    public function OwnerData()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function PropertyTypeData()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function PropertyUsageData()
    {
        return $this->belongsTo(PropertyUsage::class, 'property_usage_id');
    }

    public function EmployeeData()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function ServiceTypeData()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function UnitServicesData()
    {
        return $this->hasMany(UnitService::class, 'unit_id');
    }

    public function UnitFeatureData()
    {
        return $this->hasMany(UnitFeature::class, 'unit_id');
    }

    public function UnitImages()
    {
        return $this->hasMany(UnitImage::class, 'unit_id');
    }

    public function PropertyData()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function UnitInterests()
    {
        return $this->hasMany(UnitInterest::class);
    }
}
