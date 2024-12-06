<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function CityData()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function DeveloperData()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }

    public function OwnerData()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function EmployeeData()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function AdvisorData()
    {
        return $this->belongsTo(Advisor::class, 'advisor_id');
    }

    public function PropertiesProject()
    {
        return $this->hasMany(Property::class, 'project_id');
    }

    public function ServiceTypeData()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id');
    }

    public function getImageUrlAttribute()
    {
        $imageUrl = $this->image ? url($this->image) : url('/Brokers/Projects/default.jpg');
        if (!file_exists(public_path($this->image))) {
            $imageUrl = url('/Brokers/Projects/default.jpg');
        }
        return $imageUrl;
    }
}
