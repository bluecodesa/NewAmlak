<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ContractData()
    {
        return $this->belongsTo(Contract::class);
    }

    public function ProjectData()
    {
        return $this->belongsTo(Project::class);
    }

    public function PropertyData()
    {
        return $this->belongsTo(Property::class);
    }

    public function UnitData()
    {
        return $this->belongsTo(Unit::class);
    }

    public function RenterData()
    {
        return $this->belongsTo(Renter::class);
    }
    public function installmentsData()
    {
        return $this->belongsToMany(Installment::class, 'installment_receipt');
    }
}
