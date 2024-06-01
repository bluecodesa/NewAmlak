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

    public function DistrictData()
    {
        return $this->belongsTo(District::class, 'district_id');
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

    public function ProjectData()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function BrokerData()
    {
        return $this->belongsTo(Broker::class, 'broker_id');
    }


    public function UnitInterests()
    {
        return $this->hasMany(UnitInterest::class);
    }

    public function UnitRentPrice()
    {
        return $this->hasOne(UnitRentalPrice::class);
    }

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }


    public function getRentPriceByType()
    {
        switch ($this->rent_type_show) {
            case 'daily':
                return $this->UnitRentPrice->daily;
            case 'monthly':
                return $this->UnitRentPrice->monthly;
            case 'quarterly':
                return $this->UnitRentPrice->quarterly;
            case 'midterm':
                return $this->UnitRentPrice->midterm;
            case 'yearly':
                return $this->UnitRentPrice->yearly;
            default:
                return null;
        }
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'broker_id', 'broker_id');
    }
}
