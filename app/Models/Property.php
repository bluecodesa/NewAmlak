<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];


    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function PropertyTypeData()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function ProjectData()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function PropertyUsageData()
    {
        return $this->belongsTo(PropertyUsage::class, 'property_usage_id');
    }

    public function EmployeeData()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function OwnerData()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function ServiceTypeData()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function PropertyImages()
    {
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

    public function PropertyUnits()
    {
        return $this->hasMany(Unit::class, 'property_id');
    }
}
