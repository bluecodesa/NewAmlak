<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $guarded = [];


    protected $dates = [
        'contract_date',
    ];
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function renter()
    {
        return $this->belongsTo(Renter::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }


}
